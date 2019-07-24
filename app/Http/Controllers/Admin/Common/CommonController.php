<?php

namespace App\Http\Controllers\Admin\Common;

use Illuminate\Http\Request;
use App\Models\OperationLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Image;
use Exception;
use App\User;
use App\Role;

class CommonController extends Controller
{

    /**
     * @Author   linyiyuan
     * @DateTime 2018-04-01
     * @成功重定向
     * @param    string     $data [提示信息]
     */
    public function success($data='')
    {
        return redirect()->back()->with('message',['code' => 200, 'data' => $data]);
    }

    /**
     * @Author   linyiyuan
     * @DateTime 2018-04-01
     * @失败重定向
     * @param    string     $data [提示信息]
     */
    public function error($data='')
    {
        return redirect()->back()->with('message',['code' => 500,'data' => $data]);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-04
     * Ajax响应
     * @param     string      $code [状态码]
     * @param     string      $data [响应消息]
     */
    public function ajaxResponse($code='',$data='')
    {
        return response()->json([
                'code' => $code,
                'data' => $data
            ]);
    }


    public function toArray($data = '')
    {
        return  json_decode(json_encode($data),true);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-08
     * 上传图片
     */
    protected function uploadImageData($field, $allowImageExtension = ['png', 'jpg','jpeg'],$filePath='')
    {
        if (!$image = Input::file($field)) {
            throw new Exception('图片不能为空');
        }
            $imageType = ['image/jpeg','image/jpg','image/png'];
            // 得到上传文件源文件名
            $originalName = $image->getClientOriginalName();
            // 得到上传文件的后缀
            $ext = $image->getClientOriginalExtension();
            // 等到上传文件的类型
            $type = $image->getClientMimeType();
            // 得到上传文件的tmp绝对路径
            $realPath = $image->getRealPath();

            if (!in_array($type, $imageType)) {
               throw new Exception("上传不是图片格式");
            }
            if (!in_array($ext,$allowImageExtension)) {
                throw new Exception("上传图片类型错误");
            }

            if ($image->getSize() > 30000000) {
                throw new Exception('上传图片尺寸过大');
            }
            $flieName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;

            // $bool =  $image->storeAs(
            //             'public/'.$filePath, $flieName
            //          ); 

            // $bool= Storage::disk('public')->put($filePath.'/'.$flieName,file_get_contents($realPath));

            $contentPath = $filePath.'/'.$flieName;//拼接得到图片的名称
            
            $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));//上传图片到七牛云

            if ($bool) {
                return config('app.qiniu_cdn').$contentPath;
            }else{
                return false;
            }
            
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-08
     * 上传图片
     */
    protected function uploadMoreImageData($obj, $allowImageExtension = ['png', 'jpg','jpeg'],$filePath='')
    {
        if (!$obj) {
            throw new Exception('图片不能为空');
        }
            $imageType = ['image/jpeg','image/jpg','image/png'];
            // 得到上传文件源文件名
            $originalName = $obj->getClientOriginalName();
            // 得到上传文件的后缀
            $ext = $obj->getClientOriginalExtension();
            // 等到上传文件的类型
            $type = $obj->getClientMimeType();
            // 得到上传文件的tmp绝对路径
            $realPath = $obj->getRealPath();

            if (!in_array($type, $imageType)) {
               throw new Exception("上传不是图片格式");
            }
            if (!in_array($ext,$allowImageExtension)) {
                throw new Exception("上传图片类型错误");
            }

             if ($obj->getSize() > 3000000) {
                throw new Exception('上传图片尺寸过大');
            }
            $flieName = date('Y-m-d-H-i-s').'-'.uniqid().'.'.$ext;

            $contentPath = $filePath.'/'.$flieName;//拼接得到图片的名称
            //上传图片到七牛云
            $bool = Storage::disk('qiniu')->put($contentPath,file_get_contents($realPath));

            if ($bool) {
                return config('app.qiniu_cdn').$contentPath;
            }else{
                return false;
            }
            
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-09
     * 处理删除
     * @param     string      $id    [查询的id]
     * @param     string      $model [model对象]
     */
    protected function doDelete($id='',$model='')
    {
        if (!intval($id)) {
            return $this->ajaxResponse('500','非法参数');
        }

        $obj = $model::find($id);

        if (is_null($obj)) {
            return $this->ajaxResponse('500','获取数据失败');
        }

        if (!$obj->delete()) {
            return $this->ajaxResponse('500','删除失败');
        }

        return $this->ajaxResponse('200','删除成功');
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-11
     * @更改显示状态
     * @param     [type]      $model   [ORM对象]
     * @param     [type]      $id      [修改的id]
     * @param     [type]      $is_show [is_show 字段的值]
     */
    protected function changeIsShow($model,$id,$is_show)
    {

        if (!intval($id)) {
           return $this->error('非法参数');
        }

        if (is_null($is_show)) {
            return $this->error('状态非法参数');
        }

        $obj = $model::find($id);

        if (is_null($obj)) {
            return $this->error('获取数据失败');
        }

        if ($is_show == 0) {
            $obj->is_show = 1;
        }else if($is_show == 1){
            $obj->is_show = 0;
        }
       
        if (!$obj->save()) {
            return $this->error('修改状态失败');
        }

        return $this->success('修改状态成功');
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-11
     * @删除文件
     * @param     [type]      $filePath [文件路径]
     * @param     [type]      $basePath [storage下面得某个目录默认为pubilc文件夹]
     */
    protected function removeFile($filePath,$basePath='/public')
    {
        $basePath = '/public/';

        return Storage::delete($basePath.$filePath);

    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-04-16
     * @处理url路径
     * @param     [type]      $url [description]
     */
    public function getFullUrl($url)
    {
        if (!$url) {
            return '';
        }
        if (strtolower(substr($url, 0, 4)) == 'http') {
            return $url;
        }
        $cdn = \Config::get('app.cdn_url');
        if (strtolower(substr($cdn, 0, 4)) == 'http') {
            return $cdn . $url;
        }
        return url($url);
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-05-17
     * 获取用户ip
     */
    public static function getCliemIp($request)
    {
        return $request->getClientIp();
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-05-16
     * 记录用户操作记录
     * @param $operate  操作
     * @param $detail   详情
     * @param $result   结果
     */
    public function recordLog($operate = '',$detail = '',$result = 1)
    {
         //获取用户角色
        $user = User::find(Auth::user()->id);

        $str = '';
        foreach ($user->roles as $role) {
           $str .= $role->display_name.',';
        }

        //记录登录日志报告
        $loginLog = new OperationLog();//获取登录日志对象
        $loginLog->username = Auth::user()->name;
        $loginLog->role = rtrim($str,',');
        $loginLog->ip = $this->getIp();
        $loginLog->result = $result;
        $loginLog->operate = $operate;
        if (empty($detail)) {
             $loginLog->detail = '';
        }
        $loginLog->detail = Auth::user()->name.'在'.date('Y-m-d H:i:s',time()).$detail;

        $loginLog->save();
    }

    /**
     * @Author    linyiyuan
     * @DateTime  2018-05-17
     * 获取客户端IP
     */
    public function  getIp(){
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
        $ip = getenv("HTTP_CLIENT_IP");
        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
        $ip = getenv("REMOTE_ADDR");
        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
        $ip = $_SERVER['REMOTE_ADDR'];
        else
        $ip = "unknown";
        return($ip);
    }
}
