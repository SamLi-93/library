<?php
namespace LaneWeChat\Core;
/**
 * 卡券管理 用来替换 多媒体的上传与下载
 * Created by Lane.
 * User: yab.shi
 * Date: 147-1-13
 * Time: 上午9:51
 */
class Card{


    /**
     * 上传logo接口
     * @author: 正朴<2654035628@qq.com>
     * @param $filename 图片（image）绝对路径
     * @return Array ( [url] =>)
     */
    public static function uploadlogo($filename){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'http://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token='.$accessToken.'&type=image';
        $data = array();
        $data['media'] = Curl::addFile($filename);
        return Curl::callWebServer($queryUrl, $data, 'POST', 1 , 0);
    }

    /**
     * @descrpition 创建卡券
     * @param $tousername
     * @param $content 卡券内容
     * @return string
     */
    public static function createcard($content){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/create?access_token='.$accessToken;
        //开始
        $template = array(
            'card'=> $content
        );
        $template = json_encode($template,JSON_UNESCAPED_UNICODE);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }


    /**
     * @descrpition 查询code，判断code是否有效
     * @param $card_id
     * @param $code 
     * @return string
     */
    public static function getcardcode($card_id, $code){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/code/get?access_token='.$accessToken;
        //开始
        $template = array(
            'card_id'=> $card_id,
            'code' => $code,
            'check_consume' => true
        );
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }

    /**
     * [核销卡券]
     * @param  [type] $code       [description]
     * @return [type]             [description]
     */
    public static function comsumecardcode($code){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/code/consume?access_token='.$accessToken;
        //开始
        $template = array(
            'code' => $code
        );
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }

    /**
     * @descrpition 查询卡券信息
     * @param $card_id
     * @param $code 
     * @return string
     */
    public static function getcard($card_id){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/get?access_token='.$accessToken;
        //开始
        $template = array(
            'card_id'=> $card_id
        );
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }  


    /**
     * @descrpition 更新卡券信息
     * @param $card_id
     * @param $code 
     * @return string
     */
    public static function updatecard($card_id, $member_card){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/update?access_token='.$accessToken;
        //开始
        $template = array(
            'card_id'=> $card_id
        );
        /*{
           "card_id":"ph_gmt7cUVrlRk8swPwx7aDyF-pg",
           "member_card": {        //填写该cardid相应的卡券类型（小写）。
               "base_info": {
                   "logo_url": "http:\/\/www.supadmin.cn\/uploads\/allimg\/120216\/1_120216214725_1.jpg",
                   "color": "Color010",
                   "notice": "使用时向服务员出示此券",
                   "service_phone": "020-88888888",
                   "description": "不可与其他优惠同享\n如需团购券发票，请在消费时向商户提出\n店内均可使用，
                   仅限堂食\n餐前不可打包，餐后未吃完，可打包\n本团购券不限人数，建议2人使用，
                   超过建议人数须另收酱料费5元/位\n本单谢绝自带酒水饮料"
                   "location_id_list" : [123, 12321, 345345]
                },
                "bonus_cleared": "aaaaaaaaaaaaaa",
                "bonus_rules": "aaaaaaaaaaaaaa",
                "prerogative": ""
           }
        }*/
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    } 


    /**
     * @descrpition 删除卡券信息
     * @param $card_id
     * @param $code 
     * @return string
     */
    public static function deletecard($card_id, $code){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/card/delete?access_token='.$accessToken;
        //开始
        $template = array(
            'card_id'=> $card_id
        );
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }

    /**
     * @descrpition 获取指定卡券的统计数据
     * @param $card_id
     * @param $code 
     * @return string
     */
    public static function getcardinfo($card_id,$begin='',$end=''){
        //获取ACCESS_TOKEN
        $accessToken = AccessToken::getAccessToken();
        $queryUrl = 'https://api.weixin.qq.com/datacube/getcardcardinfo?access_token='.$accessToken;
        $begin_date = !empty($begin)?$begin:date('Y-m-d',time()-60*24*60*60);
        //结束时间默认为当前的前一天，否则报错
        $end_date = !empty($end)?$end:date('Y-m-d',time()-24*60*60);
        //开始
        $template = array(
            'card_id'=> $card_id,
            'cond_source' => 1,
            "begin_date" => $begin_date,
            "end_date" => $end_date
        );
        $template = json_encode($template);
        return Curl::callWebServer($queryUrl, $template, 'POST', 1 , 0);
    }  
}