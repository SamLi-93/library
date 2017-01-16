<?php
/**
 * Created by PhpStorm.
 * User: Sam
 * Date: 2016/6/13
 * Time: 16:26
 */

namespace backend\controllers;


use Yii;
use yii\web\Controller;
//微信框架引入方式
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/lanewechat.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/templatemessage.lib.php';
include dirname(dirname(__FILE__)).'/libs/LaneWeChat/core/usermanage.lib.php';
class WechatController extends Controller
{

    public function behaviors()
    {
        return [
        ];
    }

    function actionTest(){
    	//微信框架方法调用
        $str = "type:imagemedia_id:Eo12BGgxSZ_1NXJiqCaZRmrDwEDRGSGNoSbrou28nM1wBsnjlsC-8YiycVhevuL-created_at:1483623304";
        $back = \LaneWeChat\Core\ResponseInitiative::text('oNN3kvk_ZDt9hqa8L7cYUw23pk58', '11');
        print_r($back);
        exit;
    }
    function actionMessage(){
    	$data = array(
                'first'=>array('value'=>'您成功购买航空母舰。', 'color'=>'red'),
                'orderMoneySum'=>array('value'=>'1000000000.00', 'color'=>'red'),
                'orderProductName'=>array('value'=>'2050年豪华版', 'color'=>'red'),
                'Remark'=>array('value'=>'欢迎下次光临', 'color'=>'#676067')
            );
    	$touser = "oNN3kvk_ZDt9hqa8L7cYUw23pk58";
    	//$touser2 = "oNN3kvp7ENO9WZtJzRah2iy3N6rU";
    	$url = "http://www.baidu.com";
    	$templateIdShort = "TM00015";
    	//\LaneWeChat\Core\TemplateMessage::setIndustry('1','16');
        //$a = \LaneWeChat\Core\TemplateMessage::getTemplateId($templateIdShort);
        //$templateId = $a['template_id'];
        $templateId = "04Ehx72R5fhE7vYyhTmwjxVrjUrrqEOXr6DW3jHup7k";
        $back = \LaneWeChat\Core\TemplateMessage::sendTemplateMessage($data, $touser, $templateId, $url, $topcolor='#FF0000');
        //$back = \LaneWeChat\Core\TemplateMessage::sendTemplateMessage($data, $touser2, $templateId, $url, $topcolor='#FF0000');
        print_r($back);
        exit;
    }
    function actionGetuserlist(){
    	//微信框架方法调用
        $back = \LaneWeChat\Core\UserManage::getFansList();
        print_r($back);
        foreach ($back as $key => $value) {
        	# code...
        	print_r($value);
        	echo "</br>";
        }
        exit;
    }
    function actionGetuserinfo(){
    	//微信框架方法调用
        $back = \LaneWeChat\Core\UserManage::getUserInfo('oNN3kvlmveS2_OiI7PDFPNU-wBa4');
        print_r($back);
        exit;
    }
}