<?php

namespace app\controllers;
use app\models\Idleusers;
use app\models\Observation;
use Yii;
use app\Components\Generic;
use app\models\Pageviewed;
use app\models\Qryclick;
use app\models\Suggestion;
use app\models\Modaltrace;
use app\models\Observationmodaltrace;
use DateTime;
class CustomajaxController extends \yii\web\Controller
{

    /**
     * This action is used for storing idle users data
     * @return string
     */
    public function actionStoreidleusers(){

        $response = false;
        $model = new Idleusers();
        $model->worker_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
        $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
        $model->topic_subject = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
        $model->create_date = date("Y-m-d H:i:s");
        if ($model->save()) {
            $response = true;
        }
        return \yii\helpers\Json::encode($response);
    }

    /**
     * This action is used for storing page viewed data
     * @return string
     */
    public function actionStorepageviewed(){

        $response = 'false';
        $page_url = Yii::$app->request->post('page_url');
        $referrer = Yii::$app->request->post('referrer');
        $time_viewed = Yii::$app->request->post('time_viewed');
        $time_clicked = Yii::$app->request->post('time_clicked');
        $stay_time = Yii::$app->request->post('stay_time');
        $active_time = Yii::$app->request->post('active_time');

        $model = new Pageviewed();
        $model->page_url = $page_url;
        $model->referrer = $referrer;
        $model->worker_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
        $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
        $model->topic_name = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
        $model->time_viewed = Generic::formatJavascriptDateTimeToPhpDateTime($time_viewed);
        $model->time_clicked = Generic::formatJavascriptDateTimeToPhpDateTime($time_clicked);
        $model->stay_time = (float)$stay_time;
        $model->active_time = (float)$active_time;
        $model->create_date = date("Y-m-d H:i:s");

        if ($model->save()) {
            $response = $model;
        }
        return \yii\helpers\Json::encode($response);
    }

    /**
     * This action is used for storing search related data
     * @return string
     */
    public function actionStoresearchdata(){

        $response = 'false';
        $event = Yii::$app->request->post('event');
        $query_term = Yii::$app->request->post('query_term');
        $query_time = Yii::$app->request->post('query_time');
        $click_time = Yii::$app->request->post('click_time');
        $page_url = Yii::$app->request->post('page_url');
        $page_title = Yii::$app->request->post('page_title');
        $page_description = Yii::$app->request->post('page_description');
        $serp_rank = Yii::$app->request->post('serp_rank');

        if(isset($event) & $event != '') {

            if($event == 'search_click'){
                if(!Generic::updateBcsCount()){
                    return \yii\helpers\Json::encode($response);
                };
            }

            $qryclick = Qryclick::find()->orderBy(['query_id' => SORT_DESC])->one();
            if(empty($qryclick)){ // for first entry
                $query_id = 1;
            }else{ // for secondary entries
                $qry_term_mactched_data = Qryclick::find()->where(["query_term" => trim($query_term)])->one();
                if(!empty($qry_term_mactched_data)){ // for an existing query term
                    $query_id = $qry_term_mactched_data->query_id;
                }else{ // for a new query term
                    $query_id = $qryclick->query_id + 1;
                }
            }
            $model = new Qryclick();
            $model->worker_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $model->query_id = $query_id;
            $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $model->topic_name = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
            $model->query_term = trim($query_term);
            $model->query_time = Generic::formatJavascriptDateTimeToPhpDateTime($query_time);
            $model->create_date = date("Y-m-d H:i:s");

            if ($event == 'result_link_click') {
                $model->click_time = Generic::formatJavascriptDateTimeToPhpDateTime($click_time);
                $model->serp_rank = $serp_rank;
                $model->page_url = trim($page_url);
                $model->page_title = trim($page_title);
                $model->page_description = trim($page_description);
            }
            if($model->save()){
                $response = $model;
            }
        }
        return \yii\helpers\Json::encode($response);
    }

    /**
     * This action is used for updating thumb count of suggestion feed
     * @return string
     */
    public function actionUpdatethumbcount(){

        $suggestion = 'false';
        $img_type = Yii::$app->request->post('img_type');
        $suggestion_id = Yii::$app->request->post('suggestion_id');
        if(isset($img_type) & isset($suggestion_id)){

            $suggestion = Suggestion::findOne($suggestion_id);
            $data = Generic::updateThumbCount($suggestion,$img_type);
            $suggestion->thumbs_up = $data ['thumbs_up'];
            $suggestion->thumbs_down = $data ['thumbs_down'];
            $suggestion->thumbs_up_user_list = json_encode($data ['thumbs_up_user_list']);
            $suggestion->thumbs_down_user_list = json_encode($data ['thumbs_down_user_list']);
            $suggestion->rating = Generic::calculateRating($suggestion->thumbs_up, $suggestion->thumbs_down);
            if($suggestion->update()){
                $suggestion->rating = number_format($suggestion->rating, 2, '.', ',');
            }else{
                $suggestion = 'false';
            }
        }

        return \yii\helpers\Json::encode($suggestion);
    }

    /**
     * This action is used for generating suggestion feed section
     * @return string
     */
    public function actionFeedpopup(){

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

        return $this->renderPartial('//suggestion/feedpopup', [
            'suggestios' => $suggestios , 'topic_name' => $topic_name
        ]);
    }


    /**
     * This action is used for generating observation feed section
     * @return string
     */
    public function actionObservationpopup(){


        $topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');

        $avg_observation_1 = Observation::find()->where(['topic_id' => $topic_id])->average('observation_1');
        $avg_observation_2 = Observation::find()->where(['topic_id' => $topic_id])->average('observation_2');
        $avg_observation_3 = Observation::find()->where(['topic_id' => $topic_id])->average('observation_3');
        $topic_name = Generic::getTopic($topic_id,'topic_subject');

        return $this->renderPartial('//suggestion/observationpopup', [
            'avg_observation_1' => $avg_observation_1 ,'avg_observation_2' => $avg_observation_2 ,'avg_observation_3' => $avg_observation_3, 'topic_name' => $topic_name
        ]);
    }


    /**
     * This action is used for bing custom search request trace updating on clicking pagination
     * @return string
     */
    public function actionUpdatebcscount(){
        $response = false;
        $bcs_req = Yii::$app->request->post('bcs_req');
        if(isset($bcs_req)){
            if(Generic::updateBcsCount()){
                $response = True;
            }
        }
        return \yii\helpers\Json::encode($response);
    }

    /**
     * This action is used for storing user intercation with suggestion modal during custom search
     * @return string
     */
    public function actionSuggestionmodaltrace(){
        $response = false;
        $iteration = Yii::$app->request->post('modal_view_iteration');
        $copied_string = Yii::$app->request->post('total_copied_string');
        $pasted_string = Yii::$app->request->post('total_pasted_string');
        $active_time = Yii::$app->request->post('total_modal_active_time');
        $model = new Modaltrace();
        if(isset($iteration) && $iteration > 0){
            $model->user_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $model->topic_name = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
            $model->iteration = (int)$iteration;
            $model->active_time = (float)$active_time;
            $model->copied_string = json_encode($copied_string);
            $model->pasted_string = json_encode($pasted_string);
            $model->create_date = date("Y-m-d H:i:s");
            if($model->save()){
                $response = $model;
            }
        }
        return \yii\helpers\Json::encode($response);
    }

    /**
     * This action is used for storing user intercation with suggestion modal during custom search
     * @return string
     */
    public function actionObservationmodaltrace(){
        $response = false;
        $iteration = Yii::$app->request->post('observation_modal_view_iteration');
        $active_time = Yii::$app->request->post('total_observation_modal_active_time');
        $model = new Observationmodaltrace();
        if(isset($iteration) && $iteration > 0){


            $model->user_id = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
            $model->topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');
            $model->topic_name = Yii::$app->getRequest()->getCookies()->getValue('current_topic_subject');
            $model->iteration = (int)$iteration;
            $model->active_time = (float)$active_time;
            $model->create_date = date("Y-m-d H:i:s");
            if($model->save()){
                $response = $model;
            }
        }
        return \yii\helpers\Json::encode($response);
    }
}
