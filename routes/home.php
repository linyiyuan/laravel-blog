<?php 

/*
|--------------------------------------------------------------------------
|Home Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "home" middleware group. Now create something great!
|
*/

//博客前台入口
  Route::get('/','HomeController@index');

  Route::namespace('Home')->group(function(){

       //前台博客登录相关
       Route::prefix('blog')->group(function(){
           //博客登录页面
           Route::get('/login','LoginController@index');
           //博客注册
           Route::post('/register','RegisterController@register');
           //博客退出登录
           Route::post('/logout','LoginController@logout');
           //博客登录验证
           Route::post('/dologin','LoginController@doLogin');
           // 博客首页
           Route::get('/','IndexController@index');

           //授权相关
           Route::prefix('/OAuth')->middleware('web')->namespace('Auth')->group(function(){
               Route::get('/github','GithubController@init');
               Route::get('/weibo','WeiBoController@init');
               Route::get('/qq','QqController@init');


               Route::prefix('/callback')->group(function(){
                  Route::any('/github','GithubController@callback');
                  Route::any('/weibo','WeiBoController@callback');
                  Route::any('/qq','QqController@callback');
               });
           });
       });


		//博客文章详情页
		Route::get('/article/{id}','ArticleController@index');
 		//博客归档
 		Route::get('/list','ListController@index');
 		//博客相册
 		Route::get('/photo_album','PhotoAlbumController@index');
 		//图片列表
 		Route::get('/photo/{typename}','PhotoAlbumController@photo');
 		//博客分类
 		Route::get('/type/{id}','ListController@Type');
 		//博客标签	
 		Route::get('/tags/{id}','ListController@Tags');
 		//博客时间轴
 		Route::get('/timeline','TimeLineController@index');
 		//博客微语
 		Route::get('/gossip','GossipController@index');
 		//个人简介
 		Route::get('/resume','ResumeController@resume');
 		//404页面 
 		Route::get('/error',function(){
 			return view('home.error.404');
 		});
 		//公共聊天室
 		Route::get('/chatroom','ChatRoomController@room');

 		Route::prefix('info')->middleware('api')->group(function(){
            //用户个人信息
            Route::get('/','InfoController@info');
            //用户个人信息修改
            Route::post('/update','InfoController@update');
        });

  });


	    
	
