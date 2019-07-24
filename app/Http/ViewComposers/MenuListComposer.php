<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

/**
 * 后台导航栏共享数据
 */
class MenuListComposer
{

    /**
    * 绑定数据到视图.
    *
    * @param View $view
    * @return void
    */
    public function compose(View $view)
    {
        $menu = [
            //文章管理
            ['icon' => 'am-icon-wpforms' ,'type' => '文章管理','url' => '/article_manage','data' => [
                ['type' => '文章列表', 'url' => '/admin/article_manage/article'],
                ['type' => '标签列表', 'url' => '/admin/article_manage/tags'],
            ] ],

            //分类管理
            ['icon' => 'am-icon-tags' ,'type' => '分类管理','url' => '/type_manage','data' => [
                ['type' => '文章分类列表', 'url' => '/admin/type_manage/type'],
                ['type' => '相册分类列表', 'url' => '/admin/type_manage/photo_type'],
            ] ],

            //相册管理
            ['icon' => 'am-icon-photo' ,'type' => '相册管理','url' => '/photo_manage','data' => [
                ['type' => '相册列表', 'url' => '/admin/photo_manage/photo_album'],
                ['type' => '照片列表', 'url' => '/admin/photo_manage/picture'],
            ] ],

             //轮播图管理
            ['icon' => 'am-icon-tasks' ,'type' => '轮播图管理','url' => '/carousel_manage','data' => [
                ['type' => '轮播图列表', 'url' => '/admin/carousel_manage/carousel'],
            ] ],

            //友情链接管理
            ['icon' => 'am-icon-link' ,'type' => '友情链接管理','url' => '/links_manage','data' => [
                ['type' => '友情链接列表', 'url' => '/admin/links_manage/links'],
            ] ],

            //评论管理
            ['icon' => 'am-icon-pencil' ,'type' => '评论管理','url' => '/comment_manage','data' => [
                ['type' => '评论列表', 'url' => '/admin/comment_manage/comment'],
                ['type' => '垃圾箱', 'url' => '/admin/comment_manage/dustbin'],
            ] ],

            //留言管理
            ['icon' => 'am-icon-pencil-square-o' ,'type' => '留言管理','url' => '/admin/user2','data' => [
                ['type' => '照片列表', 'url' => 'sad'],
                ['type' => '相册列表', 'url' => 'sad'],
                ['type' => '相册分类管理', 'url' => 'sad'],
            ] ],

            //数据统计
            ['icon' => 'am-icon-line-chart' ,'type' => '数据统计','url' => '/admin/data_statistics_manage','data' => [
                ['type' => '访问量统计', 'url' => '/admin/data_statistics_manage/pv'],
            ] ],

            //消息管理
            ['icon' => 'am-icon-bullhorn' ,'type' => '消息管理','url' => '/admin/message_mange','data' => [
                ['type' => '消息列表', 'url' => '/admin/message_mange/msg'],
            ] ],

            //音乐管理
            ['icon' => 'am-icon-music' ,'type' => '音乐管理','url' => '/admin/user9','data' => [
                ['type' => '照片列表', 'url' => 'sad'],
                ['type' => '相册列表', 'url' => 'sad'],
                ['type' => '相册分类管理', 'url' => 'sad'],
            ] ],

            //站点管理
            ['icon' => 'am-icon-tachometer','type' => '站点管理','url' => 'site_manage','data' => [
                 ['type' => '个人简介', 'url' => '/admin/site_manage/about_me'],
                 ['type' => '个人简历', 'url' => '/admin/site_manage/resume'],
            ] ],

            //站点管理
            ['icon' => 'am-icon-users','type' => '游客管理','url' => 'visitor_manage','data' => [
                 ['type' => '游客列表', 'url' => '/admin/visitor_manage/tourist'],
                 ['type' => '游客统计', 'url' => '/admin/visitor_manage/statistics'],
            ] ],
            
            //用户管理
            ['icon' => 'am-icon-user' ,'type' => '用户管理','url' => 'user_manage','data' => [
                ['type' => '管理员列表', 'url' => '/admin/user_manage/user'],
                ['type' => '角色管理', 'url' => '/admin/user_manage/role'],
                
            ] ],

             //系统配置
            ['icon' => 'am-icon-gear' ,'type' => '系统配置','url' => 'system_config','data' => [
                ['type' => '系统配置', 'url' => '/admin/system_config/system'],
                ['type' => '操作日志', 'url' => '/admin/system_config/operation_log'],
            ] ],
        ];

        $view->with('menu', $menu);

       
    }
}