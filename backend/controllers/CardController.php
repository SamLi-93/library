<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\UploadedFile;
use app\models\UploadForm;
use yii\data\SqlDataProvider;
use yii\data\ActiveDataProvider;
use yii\grid\GridView;
use app\models\Lecture;

//微信框架引入方式
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/lanewechat.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/card.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/templatemessage.lib.php';
class CardController extends \yii\web\Controller
{
    public function init()
    {
        parent::init();
        //$this->card_id = '';
    }

    public function actionIndex()
    {
    	/*{
		    "card": {
		        "card_type": "MEETING_TICKET", 
		        "meeting_ticket": {
		            "base_info": {
		                "logo_url": "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0", 
		                "brand_name": "票务公司", 
		                "code_type": "CODE_TYPE_TEXT", 
		                "title": "XX会议", 
		                "color": "Color010", 
		                "notice": "使用时向检票员出示此券", 
		                "service_phone": "020-88888888", 
		                "description": "请务必准时入场", 
		                "date_info": {
		                    "type": 1, 
		                    "begin_timestamp": 1397577600, 
		                    "end_timestamp": 1494292050
		                }, 
		                "sku": {
		                    "quantity": 50000000
		                }, 
		                "get_limit": 3, 
		                "use_custom_code": false, 
		                "bind_openid": false, 
		                "can_share": true, 
		                "can_give_friend": true, 
		                "location_id_list": [
		                    123, 
		                    12321, 
		                    345345
		                ], 
		                "custom_url_name": "查看更多", 
		                "custom_url": "http://www.qq.com", 
		                "custom_url_sub_title": "6个汉字tips"
		            }, 
		            "meeting_detail": "会议时间：xxx;地点：xxx "
		        }
		    }
		}*/
        $content = array(
        	'card_type' => "MEETING_TICKET",
        	'meeting_ticket' => array(
        		'base_info' => array(
        			"logo_url" => "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0", 
	                "brand_name" => "feee票务公司1", 
	                "code_type" => "CODE_TYPE_ONLY_QRCODE", 
	                "title" => "lixin会议dfd", 
	                "color" => "Color010", 
	                "notice" => "使用时向检票员出示此券", 
	                "service_phone" => "0574-88888888", 
	                "description" => "请务必准时入场", 
	                "date_info" => array(
	                	"type" => 1, 
	                    "begin_timestamp" => 1491577600, 
	                    "end_timestamp" => 1497292050
	                ),
	                "sku" => array(
	                	"quantity" => 900
	                ),
	                "get_limit" => 3, 
	                "use_custom_code" => false, 
	                "bind_openid" => false, 
	                "can_share" => true, 
	                "can_give_friend" => true, 
	                "location_id_list" => array(
	                    1234,1221,34345
	                ),
	                "custom_url_name" => "查看更多", 
	                "custom_url" => "http://www.qq.com", 
	                "custom_url_sub_title" => "6个汉字tips"
        		),
        		'meeting_detail' => '讲座时间:2017-02-22;讲座地点:香格里拉'
        	)
        );
        $res = \LaneWeChat\Core\Card::createcard($content);
        var_dump($res);
        exit();
        /*if($res['card_id']){
        	//$this->card_id = $res['card_id'];

        	$cardobj = \LaneWeChat\Core\Card::getcard($res['card_id']);
        	echo $res['card_id'];
        	//var_dump($cardobj);
        }*/
        //var_dump($res);
        
        return $this->render('index');
    }

    function actionGetinfo(){

    	$query = Yii::$app->request->queryParams;
        $id = $query['id'];
        $list =  array();
        if(!empty($id)){
       		$info = \LaneWeChat\Core\Card::getcardinfo($id);
       		$list = $info['list'];
        }
       	return $this->render('index',[
            'list' => $list
        ]);
    }
}
