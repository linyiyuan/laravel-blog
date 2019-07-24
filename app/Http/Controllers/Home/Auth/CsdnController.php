<?php

namespace App\Http\Controllers\Home\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * CSDN OAuth 认证类(OAuth2)
 * 授权机制说明请大家参考CSDN开放平台文档：{@link http://open.csdn.net/wiki/oauth2}
 *
 * @version 1.0
 */
class CsdnController extends Controller{
    /**
     * @ignore
     */
    public $client_id;
    /**
     * @ignore
     */
    public $client_secret;
    /**
     * @ignore
     */
    public $access_token;
    /**
     * @ignore
     */
    public $refresh_token;
    /**
     * Contains the last HTTP status code returned.
     *
     * @ignore
     */
    public $http_code;
    /**
     * Contains the last API call.
     *
     * @ignore
     */
    public $url;
    /**
     * Set up the API root URL.
     *
     * @ignore
     */
    public $host = "http://api.csdn.net/";
    /**
     * Set timeout default.
     *
     * @ignore
     */
    public $timeout = 30;
    /**
     * Set connect timeout.
     *
     * @ignore
     */
    public $connecttimeout = 30;
    /**
     * Verify SSL Cert.
     *
     * @ignore
     */
    public $ssl_verifypeer = FALSE;
    /**
     * Respons format.
     *
     * @ignore
     */
    public $format = 'json';
    /**
     * Decode returned json data.
     *
     * @ignore
     */
    public $decode_json = TRUE;
    /**
     * Contains the last HTTP headers returned.
     *
     * @ignore
     */
    public $http_info;
    /**
     * Set the useragnet.
     *
     * @ignore
     */
    public $useragent = 'CSDN OAuth2 v0.1';
    /**
     * print the debug info
     *
     * @ignore
     */
    public $debug = FALSE;
    /**
     * boundary of multipart
     * @ignore
     */
    public static $boundary = '';
    /**
     * Set API URLS
     */
    /**
     * @ignore
     */
    function accessTokenURL()  { return 'http://api.csdn.net/oauth2/access_token'; }
    /**
     * @ignore
     */
    function authorizeURL()    { return 'http://api.csdn.net/oauth2/authorize'; }
    /**
     * construct CSDNOAuth object
     */
    function __construct($client_id, $client_secret, $access_token = NULL, $refresh_token = NULL) {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->access_token = $access_token;
        $this->refresh_token = $refresh_token;
    }
    /**
     * authorize接口
     *
     * 对应API：{@link http://open.csdn.net/wiki/oauth2}
     *
     * @param string $url 录成功后浏览器回跳的URL
     * @return array
     */
    function getAuthorizeURL( $url) {
        $params = array();
        $params['client_id'] = $this->client_id;
        $params['redirect_uri'] = $url;
        $params['response_type'] = 'code';
        return $this->authorizeURL() . "?" . http_build_query($params);
    }
    /**
     * access_token接口
     *
     * 对应API：{@link http://open.csdn.net/wiki/oauth2}
     *
     * @param string $type 请求的类型,可以为:code, password
     * @param array $keys 其他参数：
     *  - 当$type为code时： array('code'=>..., 'redirect_uri'=>...)
     *  - 当$type为password时： array('username'=>..., 'password'=>...)
     * @return array
     */
    function getAccessToken( $type = 'code', $keys ) {
        $params = array();
        $params['client_id'] = $this->client_id;
        $params['client_secret'] = $this->client_secret;
        if ( $type === 'code' ) {
            $params['grant_type'] = 'authorization_code';
            $params['code'] = $keys['code'];
            $params['redirect_uri'] = $keys['redirect_uri'];
        } elseif ( $type === 'password' ) {
            $params['grant_type'] = 'password';
            $params['username'] = $keys['username'];
            $params['password'] = $keys['password'];
        } else {
            throw new OAuthException("wrong auth type");
        }
        $response = $this->oAuthRequest($this->accessTokenURL(), 'POST', $params);
        $token = json_decode($response, true);
        if ( is_array($token) && !isset($token['error']) ) {
            $this->access_token = $token['access_token'];
        } else {
            throw new OAuthException("get access token failed." . $token['error']);
        }
        return $token;
    }
    /**
     * GET wrappwer for oAuthRequest.
     *
     * @return mixed
     */
    function get($url, $parameters = array()) {
        $response = $this->oAuthRequest($url, 'GET', $parameters);
        if ($this->format === 'json' && $this->decode_json) {
            $response = strtr($response, "\t", ' ');
            $response = str_replace('\"', '\'', $response);
            $response = stripslashes($response);
            return json_decode($response, true);
        }
        return $response;
    }
    /**
     * POST wreapper for oAuthRequest.
     *
     * @return mixed
     */
    function post($url, $parameters = array(), $multi = false) {
        $response = $this->oAuthRequest($url, 'POST', $parameters, $multi );
        if ($this->format === 'json' && $this->decode_json) {
            $response = strtr($response, "\t", ' ');
            $response = str_replace('\"', '\'', $response);
            $response = stripslashes($response);
            return json_decode($response, true);
        }
        return $response;
    }
    /**
     * DELTE wrapper for oAuthReqeust.
     *
     * @return mixed
     */
    function delete($url, $parameters = array()) {
        $response = $this->oAuthRequest($url, 'DELETE', $parameters);
        if ($this->format === 'json' && $this->decode_json) {
            return json_decode($response, true);
        }
        return $response;
    }
    /**
     * Format and sign an OAuth / API request
     *
     * @return string
     * @ignore
     */
    function oAuthRequest($url, $method, $parameters, $multi = false) {
        if (strrpos($url, 'http://') !== 0 && strrpos($url, 'https://') !== 0) {
            $url = "{$this->host}{$url}";
        }

        switch ($method) {
            case 'GET':
                $url = $url . '?' . http_build_query($parameters);
                return $this->http($url, 'GET');
            default:
                $headers = array();
                if (!$multi && (is_array($parameters) || is_object($parameters)) ) {
                    $body = http_build_query($parameters);
                } else {
                    $body = self::build_http_query_multi($parameters);
                    $headers[] = "Content-Type: multipart/form-data; boundary=" . self::$boundary;
                }
                return $this->http($url, $method, $body, $headers);
        }
    }
    /**
     * Make an HTTP request
     *
     * @return string API results
     * @ignore
     */
    function http($url, $method, $postfields = NULL, $headers = array()) {
        $this->http_info = array();
        $ci = curl_init();
        /* Curl settings */
        curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ci, CURLOPT_USERAGENT, $this->useragent);
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, $this->connecttimeout);
        curl_setopt($ci, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_ENCODING, "");
        curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, $this->ssl_verifypeer);
        curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, 1);
        curl_setopt($ci, CURLOPT_HEADERFUNCTION, array($this, 'getHeader'));
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, TRUE);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
                if (!empty($postfields)) {
                    $url = "{$url}?{$postfields}";
                }
        }
        if ( isset($this->access_token) && $this->access_token )
            $headers[] = "Authorization: OAuth2 ".$this->access_token;
        if ( !empty($this->remote_ip) ) {
            if ( defined('SAE_ACCESSKEY') ) {
                $headers[] = "SaeRemoteIP: " . $this->remote_ip;
            } else {
                $headers[] = "API-RemoteIP: " . $this->remote_ip;
            }
        } else {
            if ( !defined('SAE_ACCESSKEY') ) {
                $headers[] = "API-RemoteIP: " . $_SERVER['REMOTE_ADDR'];
            }
        }
        curl_setopt($ci, CURLOPT_URL, $url );
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
        curl_setopt($ci, CURLINFO_HEADER_OUT, TRUE );
        $response = curl_exec($ci);
        $this->http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);
        $this->http_info = array_merge($this->http_info, curl_getinfo($ci));
        $this->url = $url;
        if ($this->debug) {
            echo "=====post data======\r\n";
            var_dump($postfields);
            echo "=====headers======\r\n";
            print_r($headers);
            echo '=====request info====='."\r\n";
            print_r( curl_getinfo($ci) );
            echo '=====response====='."\r\n";
            print_r( $response );
        }
        curl_close ($ci);
        return $response;
    }
    /**
     * Get the header info to store.
     *
     * @return int
     * @ignore
     */
    function getHeader($ch, $header) {
        $i = strpos($header, ':');
        if (!empty($i)) {
            $key = str_replace('-', '_', strtolower(substr($header, 0, $i)));
            $value = trim(substr($header, $i + 2));
            $this->http_header[$key] = $value;
        }
        return strlen($header);
    }
    /**
     * @ignore
     */
    public static function build_http_query_multi($params) {
        if (!$params) return '';
        uksort($params, 'strcmp');
        $pairs = array();
        self::$boundary = $boundary = uniqid('------------------');
        $MPboundary = '--'.$boundary;
        $endMPboundary = $MPboundary. '--';
        $multipartbody = '';
        foreach ($params as $parameter => $value) {
            if( in_array($parameter, array('pic', 'image')) && $value{0} == '@' ) {
                $url = ltrim( $value, '@' );
                $content = file_get_contents( $url );
                $array = explode( '?', basename( $url ) );
                $filename = $array[0];
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'Content-Disposition: form-data; name="' . $parameter . '"; filename="' . $filename . '"'. "\r\n";
                $multipartbody .= "Content-Type: image/unknown\r\n\r\n";
                $multipartbody .= $content. "\r\n";
            } else {
                $multipartbody .= $MPboundary . "\r\n";
                $multipartbody .= 'content-disposition: form-data; name="' . $parameter . "\"\r\n\r\n";
                $multipartbody .= $value."\r\n";
            }
        }
        $multipartbody .= $endMPboundary;
        return $multipartbody;
    }
}
/**
 * CSDN操作类V2
 *
 * 使用前需要先手工调用csdnapi.class.php <br />
 *
 * @version 1.0
 */
class CsdnClientV2
{
    /**
     * 构造函数
     *
     * @access public
     * @param mixed $akey CSDN开放平台应用APP KEY
     * @param mixed $skey CSDN开放平台应用APP SECRET
     * @param mixed $access_token OAuth认证返回的token
     * @param mixed $refresh_token OAuth认证返回的token secret
     * @return void
     */
    function __construct( $akey, $skey, $access_token, $refresh_token = NULL)
    {
        $this->oauth = new CsdnOAuthV2( $akey, $skey, $access_token, $refresh_token );
    }
    /**
     * 开启调试信息
     *
     * 开启调试信息后，SDK会将每次请求CSDN API所发送的POST Data、Headers以及请求信息、返回内容输出出来。
     *
     * @access public
     * @param bool $enable 是否开启调试信息
     * @return void
     */
    function set_debug( $enable )
    {
        $this->oauth->debug = $enable;
    }
    /**
     * 设置用户IP
     *
     * SDK默认将会通过$_SERVER['REMOTE_ADDR']获取用户IP，在请求CSDN API时将用户IP附加到Request Header中。但某些情况下$_SERVER['REMOTE_ADDR']取到的IP并非用户IP，而是一个固定的IP（例如使用SAE的Cron或TaskQueue服务时），此时就有可能会造成该固定IP达到CSDN API调用频率限额，导致API调用失败。此时可使用本方法设置用户IP，以避免此问题。
     *
     * @access public
     * @param string $ip 用户IP
     * @return bool IP为非法IP字符串时，返回false，否则返回true
     */
    function set_remote_ip( $ip )
    {
        if ( ip2long($ip) !== false ) {
            $this->oauth->remote_ip = $ip;
            return true;
        } else {
            return false;
        }
    }
    /**
     * 获取用户的邮箱
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/user/getemail user/getemail}
     *
     * @access 需申请
     * @return array
     */
    function user_getemail()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->get('user/getemail',$params);
    }
    /**
     * 获取用户基本资料
     *
     * 返回CSDN用户的所在城市、职业、行业、工作年限、性别、个人网站、个人介绍
     * 对应API：{@link http://open.csdn.net/wiki/api/user/getinfo  user/getinfo}
     *
     * @return array
     */
    function user_getinfo()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->post('user/getinfo',$params);
    }


    /**
     * 获取用户的手机
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/user/getmobile user/getmobile}
     *
     * @access 需申请
     * @return array
     */
    function user_getmobile()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->get('user/getmobile',$params);
    }

    /**
     * 批量获取用户的头像
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/user/getavatar user/getavatar}
     *
     * @access public
     * @param string $users 用户名（多个用户名逗号分隔）
     * @param int    $size  头像大小（1,2,3,4）
     * @return array
     */
    function user_getavatar($users,$size=0)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        $params['users'] = trim($users);
        empty($size)?'':$params['size'] = intval($size);
        return $this->oauth->post('user/getavatar',$params);
    }
    /**
     * 获取博主基本信息
     *
     * 返回博客标题、博客副标题、开通博客的时间、是否是博客专家
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getinfo blog/getinfo}
     *
     * @return array
     */
    function blog_getinfo()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->post('blog/getinfo',$params);
    }

    /**
     * 获取博主的统计信息
     *
     * 返回博客访问量、收到的评论数量、原创的文章数量、转发的文章数量、翻译的文章数量、积分、排名
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getstats blog/getstats}
     *
     * @return array
     */
    function blog_getstats()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->get('blog/getstats',$params);
    }

    /**
     * 获取博主的勋章
     *
     * 返回勋章图标、勋章标题、勋章说明、颁发的原因、获得的数量
     * 对应的API：{@link http://open.csdn.net/wiki/api/blog/getmedal blog/getmedal}
     *
     * @return array
     */
    function blog_getmedal()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->get('blog/getmedal',$params);
    }

    /**
     * 获取博主的专栏
     *
     * 返回别名、所属类别、标题、描述、url地址、图片、专栏文章阅读次数
     * 对应的API：{@link http://open.csdn.net/wiki/api/blog/getcolumn blog/getcolumn}
     *
     * @return array
     */
    function blog_getcolumn()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->post('blog/getcolumn',$params);
    }
    /**
     * 获取博主的文章列表
     *
     * 返回当前页、总记录数、每页记录数、文章对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getarticlelist blog/getarticlelist}
     *
     * @param string $status 文章状态，取值范围：enabled|draft，默认enabled
     * @param int $page 当前页码，默认1
     * @param int $size 每页条数，默认15
     * @return array
     */
    function blog_getarticlelist($status='enabled',$page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['status'] = $status;
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getarticlelist',$params);
    }
    /**
     * 获取文章内容
     *
     * 返回文章id、文章标题、发表时间、阅读次数、评论次数、是否允许评论、文章类型（原创|转载|翻译）等
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getarticle blog/getarticle}
     *
     * @param int $id 文章id
     * @return array
     */
    function blog_getarticle($id)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['id'] = intval($id);
        return $this->oauth->post('blog/getarticle',$params);
    }
    /**
     * 获取博主的自定义分类
     *
     * 返回类别id、类别名称、是否隐藏、类别下的文章数量
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getcategorylist blog/getcategorylist}
     *
     * @return array
     */
    function blog_getcategorylist()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->post('blog/getcategorylist',$params);
    }
    /**
     * 获取博主使用过的的标签
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/gettaglist blog/gettaglist}
     *
     * @return array
     */
    function blog_gettaglist()
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        return $this->oauth->post('blog/gettaglist',$params);
    }

    /**
     * 获取博主收到的评论
     *
     * 返回当前页、总记录数、每页记录数、评论对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getcommentlist blog/getcommentlist}
     *
     * @param int $page 当前页码，默认1
     * @param int $size 每页条数，默认15
     * @return array
     */
    function blog_getcommentlist($page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getcommentlist',$params);
    }
    /**
     * 获取博主发出的评论
     *
     * 返回当前页、总记录数、每页记录数、评论对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getmycommentlist blog/getmycommentlist}
     *
     * @param int $page 当前页码，默认1
     * @param int $size 每页条数，默认15
     * @return array
     */
    function blog_getmycommentlist($page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getmycommentlist',$params);
    }

    /**
     * 获取文章的评论
     *
     * 返回当前页、总记录数、每页记录数、评论对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getarticlecomment blog/getarticlecomment}
     *
     * @param int $article 文章的id
     * @param int $page 	当前页码，默认1
     * @param int $size    每页条数，默认15
     * @return array
     */
    function blog_getarticlecomment($article,$page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['article'] = intval($article);
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getarticlecomment',$params);
    }
    /**
     * 修改博主信息
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/saveinfo blog/saveinfo}
     *
     * @param string $title 博客标题
     * @param string $subtitle 博客副标题
     * @return array
     */
    function blog_saveinfo($title='',$subtitle='')
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['title'] = trim($title);
        $params['subtitle'] = trim($subtitle);
        return $this->oauth->post('blog/saveinfo',$params);
    }

    /**
     * 发表/修改文章
     *
     * 返回文章id、文章url
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/savearticle blog/savearticle}
     *
     * @param array $query 格式：array('key0'=>'value0', 'key1'=>'value1', ....)。支持的key:
     * - id 		int		选填  文章id，修改文章的时候需要。
     * - title   	string  必填  文章标题
     * - type    	string  选填  文章类型（original|report|translated）
     * -description string  选填 文章简介
     * -content 	string  必填 文章内容
     * -categories 	string  选填 自定义类别（英文逗号分割）
     * -tags 		string  选填 文章标签（英文逗号分割）
     * -ip 			string  选填 用户ip
     * @return array
     */
    function blog_savearticle($query)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        foreach ($query as $k=>$v){
            $params[$k] = trim($v);
        }
        return $this->oauth->post('blog/savearticle',$params);
    }

    /**
     * 发表评论
     *
     * 返回执行状态
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/postcomment blog/postcomment}
     *
     * @param int $article 被评论的文章id
     * @param string $content 评论内容
     * @param int $reply_id 被回复的评论id
     * @param string $ip 用户ip
     * @return array
     */
    function blog_postcomment($article,$content,$reply_id=0,$ip='')
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;
        $params['article'] = intval($article);
        empty($reply_id)?'':$params['reply_id'] = intval($reply_id);
        $params['content'] = trim($content);
        empty($ip)?'':$params['ip'] = trim($ip);
        return $this->oauth->post('blog/postcomment',$params);
    }
    /**
     * 获取博客最新文章
     *
     * 返回当前页、总记录数、每页记录数、文章对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getnewarticlelist blog/getnewarticlelist}
     *
     * @access public
     * @param int $page 当前页
     * @param int $size 当前页
     * @return array
     */
    function blog_getnewarticlelist($page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getnewarticlelist',$params);
    }
    /**
     * 获取首页最新文章
     *
     * 返回当前页、总记录数、每页记录数、文章对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/gethomenewest blog/gethomenewest}
     *
     * @access public
     * @param int $channel 文章类别
     * @param int $page 当前页
     * @param int $size 每页记录数
     * @return array
     */
    function blog_gethomenewest($channel=0,$page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        empty($channel)?'':$params['channel'] = intval($channel);
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/gethomenewest',$params);
    }

    /**
     * 获取博客专家
     *
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getexpertlist  blog/getexpertlist}
     *
     * @access public
     * @param int $channel 专家类别
     * @return array
     */
    function blog_getexpertlist($channel=0)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        empty($channel)?'':$params['channel'] = intval($channel);
        return $this->oauth->post('blog/getexpertlist',$params);
    }

    /**
     * 获取专栏列表
     *
     * 返回当前页、总记录数、每页记录数、专栏对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getcolumnlist blog/getcolumnlist}
     *
     * @access public
     * @param int $channel 专栏类别
     * @param int $page 当前页
     * @param int $size 每页记录数
     * @return Array
     */
    function blog_getcolumnlist($channel=0,$page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        empty($channel)?'':$params['channel'] = intval($channel);
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getcolumnlist',$params);
    }

    /**
     * 获取专栏信息
     *
     * 返回专栏别名、所属类别、标题、描述、专栏url、图片、专栏文章的总阅读次数（专栏列表中不包含此属性）
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getcolumndetails log/getcolumndetails}
     *
     * @access public
     * @param string $alias 专栏别名
     * @return array
     */
    function blog_getcolumndetails($alias)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        $params['alias'] = trim($alias);
        return $this->oauth->post('blog/getcolumndetails',$params);
    }

    /**
     * 获取专栏的文章
     *
     * 返回当前页、总记录数、每页记录数、文章对象的数组
     * 对应API：{@link http://open.csdn.net/wiki/api/blog/getcolumnarticles blog/getcolumnarticles}
     *
     * @access public
     * @param string $alias 专栏别名
     * @param int $page 当前页
     * @param int $size 每页记录数
     * @return array
     */
    function blog_getcolumnarticles($alias,$page=1,$size=15)
    {
        $params = array();
        $params['access_token'] = $this->oauth->access_token;//access_token和client_id二者必须选择其一
        $params['alias'] = trim($alias);
        $params['page'] = intval($page);
        $params['size'] = intval($size);
        return $this->oauth->post('blog/getcolumnarticles',$params);
    }

}
