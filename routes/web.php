<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

//测试接口
Route::any('/test', 'TestController@index');

Route::get('phpinfo',function(){
	dd(phpinfo());
});

//验证验证码
Route::post('/code_captcha/check_code','Api\CodeCaptchaController@checkCode');

// Route::get('/home', 'HomeController@index')->name('home');
// Route::resource('/','Admin\IndexController')->middleware('auth');//网站入口文件
//后台路由管理
Route::group(['middleware' => ['auth']], function () {
	    Route::namespace('Admin')->group(function(){
			Route::prefix('/admin')->group(function(){
		    	//后台首页
		    	Route::resource('/index','IndexController');
		    		// 权限验证中间件
		    		Route::group(['middleware' => ['checkPermission']], function () {
			    			//用户管理模块
			    			Route::prefix('/user_manage')->group(function(){
				    			//管理员管理
							   	Route::resource('/user','UserController');
							   	//角色管理
							   	Route::resource('/role','RoleController');
			    			});

			    			//游客管理模块
			    			Route::prefix('/visitor_manage')->group(function(){
				    			//游客管理
							   	Route::resource('/tourist','VisitorController');
							   	//游客统计
							   	Route::resource('/statistics','RoleController');
			    			});

			    			//系统配置模块
			    			Route::prefix('/system_config')->group(function(){
			    				//系统配置
			    				Route::resource('/system','SystemController');
			    				//操作日志
			    				Route::resource('/operation_log','OperationLogController');
			    			});

			    			//站点模块管理
			    			Route::prefix('/site_manage')->group(function(){
			    				//个人介绍
			    				Route::resource('/about_me','IntroduceController');
			    				//个人简介
			    				Route::resource('/resume','ResumeController');
			    			});

			    			//分类模块管理
			    			Route::prefix('/type_manage')->group(function(){
			    				//文章分类
			    				Route::resource('/type','ArticleTypeController');
			    				//相册分类
			    				Route::resource('/photo_type','PhotoAlbumTypeController');
			    			});
			    			
			    			//文章模块管理
			    			Route::prefix('/article_manage')->group(function(){
			    				//文章标签
			    				Route::resource('/tags','ArticleTagsController');
			    				//文章
			    				Route::resource('/article','ArticleController');
			    				//文章详情页
			    				Route::get('/detail/{id}','ArticleDetailController@getDetail');
			    				//文章编辑器上传图片
			    				Route::post('/upload/article','ArticleDetailController@uploadImage');
			    				//批量删除文章
			    				Route::post('/detail/delmore','ArticleDetailController@delMordArtcle');
			    			});

			    			//相册模块管理
			    			Route::prefix('/photo_manage')->group(function(){
			    				//相册管理
			    				Route::resource('/photo_album','PhotoAlbumController');
			    				//相册详情
			    				Route::resource('/picture','PhotoController');
			    			});

			    			//轮播图模块管理
			    			Route::prefix('/carousel_manage')->group(function(){
			    				//轮播图管理
			    				Route::resource('/carousel','CarouselController');
			    			});

			    			//数据统计模块管理
			    			Route::prefix('/data_statistics_manage')->group(function(){
			    				// 访问量模块统计
			    				Route::get('/pv','DataStatisticsController@pv');
			    			});

			    			//评论模块管理
			    			Route::prefix('/comment_manage')->group(function(){
			    				//评论列表
			    				Route::resource('/comment','CommentController');
			    				Route::resource('/dustbin','CommentController');
			    			});

			    			//友情链接模块
			    			Route::prefix('/links_manage')->group(function(){
			    				//友情链接
			    				Route::resource('/links','LinksController');
			    			});

                            //消息管理
                            Route::prefix('/message_mange')->group(function(){
                                //友情链接
                                Route::resource('/msg','MsgController');
                            });

					});
			});
		});
});



