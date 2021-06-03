<?php

namespace app\controllers;

use app\models\Observation;
use Yii;
use app\models\Suggestion;
use app\models\Topics;
use app\models\SuggestionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\Components\Generic;
use yii\filters\AccessControl;
use \yii\web\Cookie;
use yii\base\DynamicModel;
use app\models\Completion;

/**
 * SuggestionController implements the CRUD actions for Suggestion model.
 */
class SuggestionController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['delete','index','view','create','feed','update','suggestioncreate','finish'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['feed','suggestioncreate','finish'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['delete','index','view','create','update'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Suggestion models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new SuggestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Suggestion model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Suggestion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Suggestion();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Suggestion at user end with a suggestion feed
     * @return mixed
     */
    public function actionSuggestioncreate()
    {
        $redirect_action = Generic::checkNextAction('suggestion/suggestioncreate');
        if($redirect_action != 'self'){
            return $this->redirect([$redirect_action]);
        }

        if(!Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }

        /**
         * dynamic model for suggestion and observation data collecting statrt
         */
        $model = new DynamicModel(['user_id','topic_id','topic_name','suggestion_1','suggestion_2','observation_1','observation_2','observation_3']);
        $model->addRule(['suggestion_1','suggestion_2','observation_1','observation_2','observation_3'], 'required');
        $model->addRule(['suggestion_1','suggestion_2'], 'string');
        $model->addRule(['observation_1','observation_2','observation_3'], 'integer');

        $model->user_id  = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
        $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
        $model->topic_name = Generic::getTopic($model->topic_id,'topic_subject');
        /**
         * dynamic model for suggestion and observation data collecting end
         */


        if ($model->load(Yii::$app->request->post())) {

            $suggestion_model_1 = new Suggestion();  // for storing first suggestion
            $suggestion_model_1->user_id  = $model->user_id;
            $suggestion_model_1->topic_id = $model->topic_id;
            $suggestion_model_1->topic_name = $model->topic_name;
            $suggestion_model_1->suggestion = "<p> Most useful queries in my search were <b>".$model->suggestion_1."</b></p>";
            $suggestion_model_1->create_date = date("Y-m-d H:i:s");

            if($suggestion_model_1->save()){

                $suggestion_model_2 = new Suggestion(); // for storing first suggestion
                $suggestion_model_2->user_id  = $model->user_id;
                $suggestion_model_2->topic_id = $model->topic_id;
                $suggestion_model_2->topic_name = $model->topic_name;
                $suggestion_model_2->suggestion = "<p> Most useful informations were found in my search from <b>".$model->suggestion_2."</b></p>";
                $suggestion_model_2->create_date = date("Y-m-d H:i:s");

                if($suggestion_model_2->save()){

                    $observation_model = new Observation(); // for storing observation
                    $observation_model->user_id  = $model->user_id;
                    $observation_model->topic_id = $model->topic_id;
                    $observation_model->topic_name = $model->topic_name;
                    $observation_model->observation_1 = $model->observation_1;
                    $observation_model->observation_2 = $model->observation_2;
                    $observation_model->observation_3 = $model->observation_3;
                    $observation_model->create_date = date("Y-m-d H:i:s");

                    if($observation_model->save()){
                        Yii::$app->session->setFlash('success', "Thank you for your valuable suggestion.");
                        $suggestion_create_complete = new Cookie([
                            'name' => 'suggestion_create_complete',
                            'value' => 'suggestion_create_complete',
                            'expire' => time() + 86400 * 365,
                        ]);
                        \Yii::$app->getResponse()->getCookies()->add($suggestion_create_complete);
                        return $this->redirect(['feed']);
                    }
                }
            }
        }
        return $this->render('suggestioncreate', [
            'model' => $model, 'state' => 'suggestion-create'
        ]);
    }

    /**
     * Action for showing all suggestions for a topic
     * @return mixed
     */
    public function actionFeed(){

        $redirect_action = Generic::checkNextAction('suggestion/feed');
        if($redirect_action != 'self'){
            return $this->redirect([$redirect_action]);
        }

        if(!Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }

        $topics = Topics::find()
            ->asArray()
            ->all();

        $topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
        $data = Suggestion::find()
            ->where(['topic_id' => $topic_id])
            ->orderBy(['rating' => SORT_DESC])
            ->asArray()
            ->all();


        $current_user_id  = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
        $suggestios = [];
        foreach($data as $row){
            $thumbs_up_image_class = $thumbs_down_image_class = 'enable_img';
            $thumbs_up_user_list = json_decode($row['thumbs_up_user_list'],true);
            $thumbs_down_user_list = json_decode($row['thumbs_down_user_list'],true);

            if((!empty($thumbs_up_user_list) && in_array((string)$current_user_id, $thumbs_up_user_list))){
                $thumbs_up_image_class = 'disable_img';
            }

            if((!empty($thumbs_down_user_list) && in_array((string)$current_user_id, $thumbs_down_user_list))){
                $thumbs_down_image_class = 'disable_img';
            }

            $row['thumbs_up_image_class'] = $thumbs_up_image_class;
            $row['thumbs_down_image_class'] = $thumbs_down_image_class;
            $suggestios[] = $row;
        }

        $topic_name = Generic::getTopic($topic_id,'topic_subject');

        return $this->render('feed', [
            'suggestios' => $suggestios, 'topics' => $topics , 'topic_name' => $topic_name
        ]);
    }

    /**
     * Updates an existing Suggestion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Suggestion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionFinish()
    {
        if(!Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }

        if(!Yii::$app->getRequest()->getCookies()->has('complete')){
            $model = new Completion();
            $model->user_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $model->topic_name = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');

            $completion_code = Generic::getCompletionCode();
            if($completion_code){
                $model->completion_code = (string)$completion_code;
            }
            $model->create_date = date("Y-m-d H:i:s");

            if($model->save()){
                $complete = new Cookie([
                    'name' => 'complete',
                    'value' => 'complete',
                    'expire' => time() + 86400 * 365,
                ]);
                \Yii::$app->getResponse()->getCookies()->add($complete);
                $completion_text = 'Completion code: '. $model->completion_code;
            }else{
                $completion_text = '';
            }
        }else{
            $completion_text = 'You have already completed the process.';
        }
        return $this->render('finish',['com_code' => $completion_text ]);
    }

    /**
     * Finds the Suggestion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Suggestion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Suggestion::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
