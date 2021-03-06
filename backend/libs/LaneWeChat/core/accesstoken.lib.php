<?php
namespace LaneWeChat\Core;
use Yii;
/**
 * 微信Access_Token的获取与过期检查
 * Created by Lane.
 * User: lane
 * Date: 13-12-29
 * Time: 下午5:54
 * Mail: lixuan868686@163.com
 * Website: http://www.lanecn.com
 */
class AccessToken{

    /**
     * 获取微信Access_Token
     */
    public static function getAccessToken(){
        //在获取token的过程中先判断环境
        //if(Environment::isSae($_SERVER['HTTP_APPNAME'],$_SERVER['HTTP_ACCESSKEY']))
            //return self::_getSae();
        //检测本地是否已经拥有access_token，并且检测access_token是否过期
        //$accessToken = self::_checkAccessToken();
        //if($accessToken === false){
            $accessToken = self::_getAccessToken();
        //}
        return $accessToken;
    }

    /**
     * @descrpition 从微信服务器获取微信ACCESS_TOKEN
     * @return Ambigous|bool
     */
    private static function _getAccessToken(){
        $file = Yii::$app->basePath .DIRECTORY_SEPARATOR . 'libs'. DIRECTORY_SEPARATOR . "LaneWeChat" . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'access_token.php';
        $data = json_decode(self::get_php_file($file));
        if ($data->expire_time < time()) {
          // 如果是企业号用以下URL获取access_token
          // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
          $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".WECHAT_APPID."&secret=".WECHAT_APPSECRET;
          //$res = json_decode($this->httpGet($url));
          $res = Curl::callWebServer($url, '', 'GET');
          $access_token = $res['access_token'];
          if ($access_token) {
            $data->expire_time = time() + 7000;
            $data->access_token = $access_token;
            self::set_php_file($file, json_encode($data));
          }
        } else {
          $access_token = $data->access_token;
        }
        return $access_token;
    }

    /**
     * @descrpition 检测微信ACCESS_TOKEN是否过期
     *              -10是预留的网络延迟时间
     * @return bool
     */
    private static function _checkAccessToken(){
        //获取access_token。是上面的获取方法获取到后存起来的。
        //$accessToken = YourDatabase::get('access_token');
        $data = file_get_contents('access_token');
        $accessToken['value'] = $data;
        if(!empty($accessToken['value'])){
            $accessToken = json_decode($accessToken['value'], true);
            if(time() - $accessToken['time'] < $accessToken['expires_in']-10){
                return $accessToken;
            }
        }
        return false;
    }

    /**
    *@descrpition 在SAE平台上获取access_token
    * @return string
    */
    private static function _getSae(){
        //从memcache中获取access_token
        $accessToken = self::_getFromMemcache();
        return $accessToken;
    }

    /**
    *@descrpition 从memcache中获取access_token
    * @return string
    */
    private static function _getFromMemcache(){
        //初始化memcache,前提是已经开启memcache服务
        if(function_exists('memcache_init') && function_exists('memcache_get') && function_exists('memcache_set')){
            $mmc=memcache_init();
            //从memcache之中取值
            $accessToken = memcache_get($mmc,'key');
            //看memcache之中是否的值是否过期/存在,true直接返回
            if(!empty($accessToken)){
                return $accessToken;
            }else{
                //如果memcache中的值已经过期/不存在,再次请求获取
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APPID.'&secret='.WECHAT_APPSECRET;
                $accessToken = Curl::callWebServer($url, '', 'GET');
                if(!isset($accessToken['access_token'])){
                    return Msg::returnErrMsg(MsgConstant::ERROR_GET_ACCESS_TOKEN, '获取ACCESS_TOKEN失败');
                }
                //将access_token的值存入memcache并且设置其过期时间2000秒,微信平台默认是7200秒,此处设置的值比7200小就可以
                $val=memcache_set($mmc,'key',$accessToken['access_token'],0,7000);
                return $accessToken['access_token'];
            }
        }else{
            exit('SAE环境下不支持写文件.并且您尚未开启memcache.请在lanewechat/core/accesstoken.lib.php的getAccessToken()方法为入口自行编写存取access_token的方式');
        }
    }

    /**
    *@descrpition 从文件中获取access_token
    * @return string
    */
    private static function _getFromFile(){
        if(self::_existsToken()){
            if(self::_expriseToken()){
                //重新获取一次access_token，并且将文件删除，重新向文件里面写一次
                $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APPID.'&secret='.WECHAT_APPSECRET;
                $accessToken = Curl::callWebServer($url, '', 'GET');
                if(!isset($accessToken['access_token'])){
                    return Msg::returnErrMsg(MsgConstant::ERROR_GET_ACCESS_TOKEN, '获取ACCESS_TOKEN失败');
                }
                unlink('token.txt');
                file_put_contents('token.txt', $accessToken['access_token']);
            }else{
                $accessToken = file_get_contents('token.txt');
            }
        }else{
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.WECHAT_APPID.'&secret='.WECHAT_APPSECRET;
            $accessToken = Curl::callWebServer($url, '', 'GET');
            if(!isset($accessToken['access_token'])){
                return Msg::returnErrMsg(MsgConstant::ERROR_GET_ACCESS_TOKEN, '获取ACCESS_TOKEN失败');
            }
            file_put_contents('token.txt', $accessToken['access_token']);
        }
        return $accessToken['access_token'];;
    }

    /**
    *@descrpition 判断token.txt文件是否存在
    * @return bool
    */
    private static function _existsToken(){
        if(file_exists('token.txt')){
            return true;
        }else{
            return false;
        }
    }

    /**
    *@descrpition 获取token.txt的创建时间，并且与当前执行文件的时间进行对比
    * @return string
    */
    private static function _expriseToken(){
        //文件创建时间
        $ctime = filectime('token.txt');
        if((time() - $ctime) >= 7000) {
            return true;
        }else{
            return false;
        }
    }
    private static  function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private static  function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}
?>