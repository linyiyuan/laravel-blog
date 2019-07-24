<?php

namespace App\Http\Controllers\Home;

use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Home\Common\BaseController;
use Illuminate\Support\Facades\Validator;

class InfoController extends BaseController
{
	/**
	 * @Author    linyiyuan
	 * @DateTime  2018-08-16
	 * @copyright 显示用户信息页面
	 */
    public function info()
    {
    	if (!userInfo()) {
    		return Redirect('/blog/login');
    	}
    	return view('home.info');
    }

    public function update(Request $request)
    {
        $username = $request->get('username');
        $token = $request->get('_token');
        $password = $request->password;
        $password_confirmation = $request->password_confirmation;
        $email = $request->email;

        $rules = [
            'username' =>'required',
            '_token' => 'required',
        ];

        $message = [
            'username.required' => '请输入用户名',
            '_token' => '修改失败 认证失败'
        ];

        $data = [
            'username' => $username,
            '_token' => $token
        ];
        $validator = Validator::make($data,$rules,$message);

        if (!empty($error=$validator->messages()->first())) return redirect('/info')->with('error',$error);

        if(empty($visitor=Visitor::where('_token',$token)->first())) return redirect('/info')->with('error','token 认证失败');

        $visitor->username = $username ?? '';
        $visitor->email = $email ?? '';

        if (!empty($password)){
            if ($password != $password_confirmation) return redirect('/info')->with('error','两次密码输入不一致');
            $visitor->userpass = Hash::make($password) ?? '';
        }

        if ($request->file('img')) {
            try {
                if (!$path = $this->uploadImageData('cover',['png','jpeg','jpg'],'home/info')) {
                    return redirect('/info')->with('error','图片保存失败');
                }
            } catch (\Exception $e) {
                return redirect('/info')->with('error',$e->getMessage());
            }
            $visitor->img = $path;
        }

        if (!$visitor->save()) return redirect('/info')->with('error','保存信息失败');

        return redirect('/info')->with('success','保存信息成功');



    }
}
