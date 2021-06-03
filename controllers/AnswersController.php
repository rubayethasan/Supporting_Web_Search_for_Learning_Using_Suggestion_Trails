<?php

namespace app\controllers;

use Yii;
use app\models\Answers;
use app\Components\Generic;
use app\models\AnswersSearch;
use app\models\Bcscode;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Cookie;
use yii\filters\AccessControl;

/**
 * AnswersController implements the CRUD actions for Answers model.
 */
class AnswersController extends Controller
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
                'only' => ['index','view','customsearch','update','create','delete','withsearch','withoutsearch'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['customsearch','withsearch','withoutsearch'],
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index','view','update','create','delete'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Answers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnswersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Answers model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        if(!Yii::$app->getRequest()->getCookies()->has('qn_set_without_search_complete')){
            $instruction = 'PRE SEARCH QUESTIONNAIRE ANSWER EVALUATION. For improved answer please search.';
            $btn_text = 'Proceed to Custom Search';
            $btn_url = 'customsearch';
        }else{
            $instruction = 'POST SEARCH QUESTIONNAIRE ANSWER EVALUATION. Please provide your suggestion';
            $btn_text = 'Proceed to Suggestion Box';
            $btn_url = 'suggestion/create';
        }

        return $this->render('view', [
            'model' => $this->findModel($id), 'instruction' => $instruction, 'btn_text'=>$btn_text, 'btn_url'=>$btn_url
        ]);
    }

    /**
     * Creates a new Answers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Answers();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model
        ]);
    }

    /**
     * Creates a users answer on a specific topic without searching.
     * If creation is successful, the browser will be redirected to the 'custom search' page where user need to answer with searching
     * @return mixed
     */
    public function actionWithoutsearch(){
        //if(Yii::$app->getRequest()->getQueryParam('u_t')){
        if(Yii::$app->getRequest()->getQueryParam('u') && !Yii::$app->request->post()){
            //$ut = Yii::$app->getRequest()->getQueryParam('u_t');
            $u = Yii::$app->getRequest()->getQueryParam('u');
            //$u_t = explode('_',$ut);
            $t = Generic::genarateCustomRandomTopic();
            $u_t = [$u, $t];
            Generic::addUseridTopicidCookie($u_t);
            $current_user_id = $u_t[0];
            $current_topic_id = $u_t[1];
            $current_topic_subject = Generic::getTopic($u_t[1],'topic_subject');
        }else if(Yii::$app->getRequest()->getCookies()->has('current_topic_id')){

            $redirect_action = Generic::checkNextAction('answers/withoutsearch');
            if($redirect_action != 'self'){
                return $this->redirect([$redirect_action]);
            }

            $current_user_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $current_topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $current_topic_subject = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
        }else{ // if user loss user_id and topic_id cookie
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }

        $current_topic_questions = Generic::getQuestions($current_topic_id);
        $attributes = [];
        $labels = [];
        $right_answers = [];

        foreach($current_topic_questions as $current_topic_question){
            $attribute = $current_topic_question ['question'];
            $labels[] = trim($attribute);
            $attribute = str_replace('-',' ',$attribute);
            $attribute = preg_replace('/[^A-Za-z0-9\-]/', '_', $attribute);
            $attributes[] = trim($attribute);
            $right_answers[] = trim($current_topic_question ['answer']);
        }

        $model = new \yii\base\DynamicModel($attributes);
        $model->addRule($attributes, 'string');
        $model->addRule($attributes, 'required');
        //$model->defineAttribute('test1', 'testewrwwe');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $user_answer = [];
            $question_answer = [];
            foreach ($attributes as $key => $attribute) {
                $user_answer[] = trim($model->$attribute);
                $question_answer[] = array('question' => $labels[$key], 'user_answer' => $user_answer[$key], 'right_answer' => $right_answers[$key]);
            }

            $answer_difference = array_diff_assoc($right_answers, $user_answer);
            $total_qs = sizeof($current_topic_questions);
            $wrong_ans = sizeof($answer_difference);
            $right_ans = $total_qs - $wrong_ans;

            $answerModel = new Answers();
            $answerModel->worker_id = $current_user_id;
            $answerModel->topic_id = $current_topic_id;
            $answerModel->topic_subject = $current_topic_subject;
            $answerModel->question_answer = json_encode($question_answer);
            $answerModel->right_answer = $right_ans;
            $answerModel->wrong_answer = $wrong_ans;
            $answerModel->result = ($right_ans / $total_qs);
            $answerModel->state = "withoutsearch";
            $answerModel->create_date = date("Y-m-d H:i:s");

            if ($answerModel->save()) {
                Yii::$app->session->setFlash('success', "Answer Submission Successful");
                //return $this->redirect(['view', 'id' => $answerModel->id]);
                if ($answerModel->save()) {
                    Yii::$app->session->setFlash('success', "Answer Submission Successful");
                    //return $this->redirect(['view', 'id' => $answerModel->id]);
                    $without_search_complete = new Cookie([
                        'name' => 'without_search_complete',
                        'value' => 'without_search_complete',
                        'expire' => time() + 86400 * 365,
                    ]);
                    \Yii::$app->getResponse()->getCookies()->add($without_search_complete);
                    //return $this->redirect(['answers/withsearch']);
                    return $this->redirect(['answers/customsearch']);
                }

            }
        }

        $instruction = "<div>
                            <h3>Thank you for willing to participate! Your participation will help us greatly and we appreciate your time.</h3>
                        </div>
                        <div>
                            <h4>
                                <ul>
                                    <li>Please respond to the following questions WITHOUT searching for the answers on the Web.</li>
                                    <li>Your responses in this first part will not effect the payment.</li>
                                    <li>The purpose is ONLY to understand how much people know about a given topic.</li>
                                    <li>This will take most people between 2-5 minutes to complete.</li>
                                </ul>
                            </h4>
                        </div>
                        <div>
                            <h4>Please judge whether the following statements are 'TRUE' or 'FALSE'. If you are not sure about the correct answer, select 'I DO NOT KNOW'.</h4>
                        </div>";
        return $this->render('feedback', [
            'model' => $model, 'attributes' => $attributes, 'labels' => $labels, 'right_answers' => $right_answers, 'instruction' => $instruction, 'current_topic_subject' => $current_topic_subject, 'action' => 'withoutsearch'
        ]);
    }

    /**
     * Creates a users answer on a specific topic without searching.
     * If creation is successful, the browser will be redirected to the 'custom search' page where user need to answer with searching
     * @return mixed
     */
    public function actionWithsearch(){

        $redirect_action = Generic::checkNextAction('answers/withsearch');
        if($redirect_action != 'self'){
            return $this->redirect([$redirect_action]);
        }

        if(Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            $current_user_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $current_topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $current_topic_subject = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
        }else{ // if user loss user_id and topic_id cookie
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }

        $current_topic_questions = Generic::getQuestions($current_topic_id);
        $attributes = [];
        $labels = [];
        $right_answers = [];

        foreach($current_topic_questions as $current_topic_question){
            $attribute = $current_topic_question ['question'];
            $labels[] = trim($attribute);
            $attribute = str_replace('-',' ',$attribute);
            $attribute = preg_replace('/[^A-Za-z0-9\-]/', '_', $attribute);
            $attributes[] = trim($attribute);
            $right_answers[] = trim($current_topic_question ['answer']);
        }

        $model = new \yii\base\DynamicModel($attributes);
        $model->addRule($attributes, 'string');
        $model->addRule($attributes, 'required');
        //$model->defineAttribute('test1', 'testewrwwe');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user_answer = [];
            $question_answer = [];
            foreach ($attributes as $key => $attribute) {
                $user_answer[] = trim($model->$attribute);
                $question_answer[] = array('question' => $labels[$key], 'user_answer' => $user_answer[$key], 'right_answer' => $right_answers[$key]);
            }

            $answer_difference = array_diff_assoc($right_answers, $user_answer);
            $total_qs = sizeof($current_topic_questions);
            $wrong_ans = sizeof($answer_difference);
            $right_ans = $total_qs - $wrong_ans;

            $answerModel = new Answers();
            $answerModel->worker_id = $current_user_id;
            $answerModel->topic_id = $current_topic_id;
            $answerModel->topic_subject = $current_topic_subject;
            $answerModel->question_answer = json_encode($question_answer);
            $answerModel->right_answer = $right_ans;
            $answerModel->wrong_answer = $wrong_ans;
            $answerModel->result = ($right_ans / $total_qs);
            $answerModel->state = "withsearch";
            $answerModel->create_date = date("Y-m-d H:i:s");;

            if ($answerModel->save()) {
                Yii::$app->session->setFlash('success', "Answer Submission Successful");
                //return $this->redirect(['view', 'id' => $answerModel->id]);
                $with_search_complete = new Cookie([
                    'name' => 'with_search_complete',
                    'value' => 'with_search_complete',
                    'expire' => time() + 86400 * 365,
                ]);
                \Yii::$app->getResponse()->getCookies()->add($with_search_complete);
                return $this->redirect(['suggestion/suggestioncreate']);
            }
        }
        $instruction = "<div>
                            <h3>Thank you for willing to participate! Your participation will help us greatly and we appreciate your time.</h3>
                            <h4>
                                <ul>
                                    <li>Please respond to the following questions WITHOUT searching for the answers on the Web.</li>
                                    <li>You have only 5 minutes to answer questions.</li>
                                    <li>The purpose of this test is to see what information you have learned through the search process.</li>
                                    <li>For each question that you correctly answer in the final test, you will receive a BONUS of 0.01 USD.</li>
                                    <li>For each incorrect response however, you will lose 0.01 USD as a penalty.</li>
                                    <li>If you are unsure about the answer, please select 'I DO NOT KNOW' to avoid the penalty.</li>
                                    <li>Once you begin the test, you will not be allowed to search the web for answers due to time limits for each question.</li>
                                </ul>
                            </h4>
                            <h4>Please judge whether the following statements are 'TRUE' or 'FALSE'. If you are not sure about the correct answer, select 'I DO NOT KNOW'.</h4>
                        </div>";
        return $this->render('feedback', [
            'model' => $model, 'attributes' => $attributes, 'labels' => $labels, 'right_answers' => $right_answers, 'instruction' => $instruction, 'current_topic_subject' => $current_topic_subject, 'action' => 'withsearch'
        ]);
    }

    /**
     * This one is a specially created custom search page with bing custom search api.
     * @return mixed
     */
    public function actionCustomsearch(){

        $redirect_action = Generic::checkNextAction('answers/customsearch');
        if($redirect_action != 'self'){
            return $this->redirect([$redirect_action]);
        }

        if(!Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");
            return $this->redirect(['site/index']);
        }


        $bcscode = Bcscode::find()
            ->where(["status" => 'active'])
            ->one();

        $current_topic_subject = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
        return $this->render('customsearch',['current_topic_subject' => $current_topic_subject, 'search_code' => $bcscode->search_code]);
    }

    /**
     * Updates an existing Answers model.
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
     * Deletes an existing Answers model.
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


    /**
     * Finds the Answers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Answers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Answers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
