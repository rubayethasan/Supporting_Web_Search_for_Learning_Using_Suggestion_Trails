<?php
/**
 * Created by PhpStorm.
 * User: mdrubayethasan
 * Date: 08.03.18
 * Time: 23:13
 */

namespace app\Components;

use Yii;
use app\models\Topics;
use app\models\Questions;
use app\models\Bcscode;
use app\models\Completioncode;
use \yii\web\Cookie;



class Generic
{
    public static function checkUt(){
        //$ut = Yii::$app->getRequest()->getQueryParam('u_t');
        $u = Yii::$app->getRequest()->getQueryParam('u');
        if(!Yii::$app->getRequest()->getCookies()->has('current_topic_id')){
            if($u){
                $t = Generic::genarateCustomRandomTopic();
                $u_t = [$u, $t];
                //$u_t = explode('_',$ut);
                self::addUseridTopicidCookie($u_t);
            }else{
                Yii::$app->session->setFlash('danger', "User Id and Topic Id missing. Please retry from crowdsource platform again with those.");

            }
        }
    }

    public static function updateThumbCount($data,$type){

        $thumbs_up = $data['thumbs_up'];
        $thumbs_down = $data['thumbs_down'];
        $thumbs_up_user_list = json_decode($data['thumbs_up_user_list'],true);
        $thumbs_down_user_list = json_decode($data['thumbs_down_user_list'],true);
        $user_id  = Yii::$app->getRequest()->getCookies()->getValue('current_user_id');
        $topic_id = Yii::$app->getRequest()->getCookies()->getValue('current_topic_id');


        if($type == 'thumbs_up'){
            $thumbs_up += 1;
            $thumbs_up_user_list[]= $user_id;
            if(!empty($thumbs_down_user_list) && in_array((string)$user_id, $thumbs_down_user_list)){

                $key = array_search((string)$user_id,$thumbs_down_user_list);
                array_splice($thumbs_down_user_list, $key,1);

                $thumbs_down = ($thumbs_down > 0)? $thumbs_down - 1 : 0;
            }
        }else if($type == 'thumbs_down'){
            $thumbs_down += 1;
            $thumbs_down_user_list[]= $user_id;
            if(!empty($thumbs_up_user_list) && in_array((string)$user_id, $thumbs_up_user_list)){

                $key = array_search((string)$user_id,$thumbs_up_user_list);
                array_splice($thumbs_up_user_list, $key,1);

                $thumbs_up = ($thumbs_up > 0)? $thumbs_up - 1 : 0;
            }
        }

        $data['thumbs_up'] = $thumbs_up;
        $data['thumbs_down'] = $thumbs_down;
        $data['thumbs_up_user_list'] = $thumbs_up_user_list;
        $data['thumbs_down_user_list'] = $thumbs_down_user_list;

        return $data;
    }

    public static function getTopic($id,$key){
        $topic = Topics::find()
            ->where(["id" => $id])
            ->asArray()
            ->one();
        return $topic[$key];

    }

    public static function getTopicList(){
        $topic_list = [];
        $topics = Topics::find()
            ->asArray()
            ->all();

        foreach($topics as $topic){
            $topic_list[$topic['id']] = $topic['topic_subject'];


        }

        return $topic_list;
    }

    public static function getQuestions($id){
        $questions = Questions::find()
            ->where(["topic_id" => $id])
            ->asArray()
            ->all();
        return $questions;
    }

    public static function deleteAllCookie(){
        $list_cookie = [
            'current_user_id',
            'current_topic_id',
            'current_topic_subject',
            'without_search_complete',
            'custom_search_complete',
            'with_search_complete',
            'suggestion_create_complete',
            'complete'
        ];
        $cookies = Yii::$app->response->cookies;
        foreach ($list_cookie as $cookie_name)
        {
            $cookies->remove($cookie_name);
            unset($cookies[$cookie_name]);
        }
    }

    public static function addUseridTopicidCookie($u_t){

        self::deleteAllCookie();

        $current_user_id = new Cookie([
            'name' => 'current_user_id',
            'value' => (int)$u_t[0],
            'expire' => time() + 86400 * 365,
        ]);

        $current_topic_id = new Cookie([
            'name' => 'current_topic_id',
            'value' => (int)$u_t[1],
            'expire' => time() + 86400 * 365,
        ]);

        $current_topic_subject = new Cookie([
            'name' => 'current_topic_subject',
            'value' => self::getTopic($u_t[1],'topic_subject'),
            'expire' => time() + 86400 * 365,
        ]);

        \Yii::$app->getResponse()->getCookies()->add($current_user_id);
        \Yii::$app->getResponse()->getCookies()->add($current_topic_id);
        \Yii::$app->getResponse()->getCookies()->add($current_topic_subject);

        //echo 'klfdjgf';

    }

    public static function checkNextAction($param){

        if(Yii::$app->getRequest()->getCookies()->has('suggestion_create_complete')){
            $redirect_action = 'suggestion/feed';
            //}else if(Yii::$app->getRequest()->getCookies()->has('custom_search_complete')){
        }else if(Yii::$app->getRequest()->getCookies()->has('with_search_complete')){
            $redirect_action = 'suggestion/suggestioncreate';
        //}else if(Yii::$app->getRequest()->getCookies()->has('custom_search_complete')){
        }else if(Yii::$app->getRequest()->getCookies()->getValue('custom_search_complete',(isset($_COOKIE["custom_search_complete"])))){
            $redirect_action = 'answers/withsearch';
        }else if(Yii::$app->getRequest()->getCookies()->has('without_search_complete')){
            $redirect_action = 'answers/customsearch';
        }else{
            $redirect_action = 'answers/withoutsearch';
        }

        return ($redirect_action == $param)?'self':$redirect_action;
    }

    public static function calculateRating($positive, $negative) {
        return ((($positive + 1.9208) / ($positive + $negative) - 1.96 * sqrt((($positive * $negative) / ($positive + $negative)) + 0.9604) / ($positive + $negative)) / (1 + 3.8416 / ($positive + $negative)));
    }

    public static function genarateCustomRandomTopic(){
        $file_path = Yii::$app->basePath."/web/files/topic-trace.txt";
        $topic_id = 1;
        if(file_exists($file_path)){
            $file = fopen($file_path, "r") or die("Unable to open file!");
            $val = fgets($file);
            fclose($file);
            $topic_id = ($val < 10 ) ? $val + 1 : 1;
        }
        $file = fopen($file_path, "w") or die("Unable to open file!");
        fwrite($file, $topic_id);
        fclose($file);
        return $topic_id;
    }

    public static function updateBcsCount(){

        $bcs_code = Bcscode::find()
            ->where(["status" => 'active'])
            ->one();

        //$bcs_code = Bcscode::findOne($bcscode['id']);
        if($bcs_code->req_num > 900){
            $next_id = $bcs_code->id + 1;
            $bcs_code -> status = 'inactive';
            $bcs_code -> save();

            $bcs_code = Bcscode::findOne($next_id);
            $bcs_code -> req_num = 1;
            $bcs_code -> status = 'active';
        }else{
            $bcs_code -> req_num = $bcs_code->req_num + 1;
        }

        if($bcs_code -> save()){
            return true;
        }else{
            return false;
        }
    }

    public static function formatJavascriptDateTimeToPhpDateTime($time_str){

        $time_str_arr = explode('GMT',trim($time_str));
        return date('Y-m-d H:i:s',strtotime(trim($time_str_arr[0])));

    }

    /**
     * Method for getting completion code
     * @return bool
     */
    public static function getCompletionCode(){
        $code = false;
        $model = Completioncode::findOne(['status' => '0']);
        $model->status = '1';
        if($model->save()){
            $code = $model['code'];
        }
        return $code;
    }

    /**
     * Method for generating completion code
     */
    public static function generateCompletionCode(){

        $completion_codes = [];
        $characters = 'ABCDEFGHIJKLMNOPQRSTabcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($characters) - 1;
        $i = 0;
        while($i < 500){
            $string = '';
            for ($j = 0; $j < 18; $j++) {
                $string .= $characters[mt_rand(0, $max)];
            }
            if(!in_array($string,$completion_codes)){
                $completion_codes[$i]=$string;
                $i++;
            }
        }

        $csv_file_path = Yii::$app->basePath."/web/files/completion-codes.csv";
        $csv_file = fopen($csv_file_path,"a");

        $text_file_path = Yii::$app->basePath."/web/files/completion-codes.text";
        $text_file = fopen($text_file_path,"a");

        foreach ($completion_codes as $key => $value)
        {
            $model = new Completioncode();
            $model->code = $value;

            if($model->save()){

                $csv_string = [$key+1,$value];
                fputcsv($csv_file,$csv_string);

                fputs($text_file,$value."\n");

            }else{
                echo 'error';
            }
        }
        fclose($csv_file);
        fclose($text_file);
    }
}