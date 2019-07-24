<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
//接口Api
Route::namespace('Api')->group(function(){
	Route::prefix('/photo')->group(function(){
    	Route::get('/detail','PhotoController@getDetail');
	});
	Route::prefix('/code_captcha')->group(function(){
		//检查手机验证码
    	Route::post('/phone_code','PhoneCaptchaController@getPhoneCode');
	});
	//提交评论
	Route::post('/comment','CommentController@addComment');
	//删除评论
	Route::delete('/comment/del/{id}','CommentController@delComment');
	//上传评论图片接口
	Route::post('/comment/upload','CommentController@uploadImage');
	//获取博客访问量统计数据
	Route::get('/data_statistics/visitor','DataStatisticsController@getData');
    //文章点赞操作
	Route::post('/article/praise','ArticleController@praise');

});

