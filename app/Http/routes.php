<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Spatie\Backup\Helpers\Format;
use Spatie\Backup\BackupDestination\BackupDestination;
//use Spatie\Backup\BackupDestination\BackupCollection;
use Illuminate\Contracts\Filesystem\Filesystem;

Route::get('/foo', function (Filesystem $disk) {
    //原始命令可以新加入命令不可以不知道是不是这个插件的问题 不行明天换一个插件看看
    //的确是 另一个插件就是好使的 难道是因为这个是原生命令(mysql-dump) 还是因为和laravel版本不匹配
    //中秋快乐 最近够呛了 要考试了  明天上公路 再过两天考试 再有一天, 明天考试,加油 一次过. 考试过去了 噢耶
    //今天关顾看科四了没看这个 再过两天考科四  再过一天考试, 明天科四 争取一把过 噢耶 嘿嘿 考完了 一百分一次过 耶耶
    //计划不如变化快啊 本来想今天看看这个的 结果下午出去就在没有时间了
    //数据库问题已经解决 不过今天没搞 明天开始搞前端 链接后端备份了
    //今天刚到北京 看来弄不了了 明天搞
    //17年了 又回来了 额... 测试下ssh同步好使不
    //完了 hexo还是不好使啊 真没法
    //还是没出来这个怎么这么麻烦啊  wtf  怎么没有提交成功啊
    //hexo 已经修好了 不过今天一直忙没时间写东西了 那个这个补一下吧
    // $aa = Artisan::call('backup:run');
    // dump($aa);  昨天没有推送 不对啊
    $lj =  Config::get('filesystems.disks.local.root')."\\elick-blog";
    $a =  File::Files($lj);
    $b = count($a);
    dump($lj);
    dump($a);
    dump($b);
    

    //这个用插件的类来计算所占空间大小, 第二个参数可以改成elick-blog 不过这个实在app下那个目录, 不是backups那个
    //回头再看看设置里怎么改掉这个 让计算这个也是自定义那个目录 (这个在配置项monitorBackups里)
    //这个类很有趣默认disk路径可以用new这么写 如果自定义可以用静态方法create这么写  两方面都兼顾了 这个写法以前没见过 学习了
    //$bd = new BackupDestination($disk,Config::get('laravel-backup.monitorBackups.0.name'),Config::get('laravel-backup.monitorBackups.0.disks'));
    
    //这个配置很麻烦的一点就是把参数写死了,要不然就是空的,而且这个配置的参数有点深
    //可以做遍历循环显示 如同dackup::list 不过暂时用不到这个 还是简单点 只保存一个存储点好了
    $bd = BackupDestination::create(Config::get('laravel-backup.monitorBackups.0.disks.0'),Config::get('laravel-backup.monitorBackups.0.name'));
    //dump($bd);
    $t = $bd->getUsedStorage();

    $dd = Format::getHumanReadableSize($t);
    echo $dd;


    // dump(Config::get('laravel-backup.backup'));
    // dump(Config::get('laravel-backup.monitorBackups'));
    // dump(Config::get('laravel-backup.monitorBackups.0.name'));
    // dump(Config::get('laravel-backup.monitorBackups.0.disks'));




});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'web'], function () {
    //homepage
    Route::get('/', ['as' => 'web.home', 'uses' => 'PagesController@home']);
    Route::get('blog', ['as' => 'web.blog', 'uses' => 'PagesController@home']);
    Route::get('/blog/{posts}', ['as' => 'web.post', 'uses' => 'PagesController@post']);
    Route::get('/category/{categories}', ['as' => 'web.category', 'uses' => 'PagesController@category']);

});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'api', 'middleware' => 'api', 'namespace' => 'Api'], function () {
    //posts
    Route::post('posts/{posts}/publish', ['as' => 'api.posts.publish', 'uses' => 'PostsController@publish']);
    Route::post('posts/{posts}/image', ['as' => 'api.posts.updateImage', 'uses' => 'PostsController@updateImage']);
    Route::resource('posts', 'PostsController', ['except' => ['create', 'edit']]);

    //categories
    Route::resource('categories', 'CategoriesController', ['except' => ['create', 'edit']]);

    //posts categories
    Route::patch('posts/{posts}/categories', ['as' => 'api.posts.categories.sync', 'uses' => 'PostsCategoriesController@sync']);
    Route::resource('posts.categories', 'PostsCategoriesController', ['only' => ['index', 'store', 'destroy']]);

    //categories posts
    Route::get('categories/{categories}/posts', [ 'as' => 'api.categories.posts.index', 'uses' => 'CategoriesPostsController@index']);

    //users
    Route::get('me', ['as' => 'api.me.show', 'uses' => 'MeController@show']);
    Route::patch('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
    Route::put('me', ['as' => 'api.me.update', 'uses' => 'MeController@update']);
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'dashboard', 'middleware' => 'authorized:view-dashboard'], function () {  //这个中间件还是不太懂
    Route::get('/{vue_capture?}', function () {
        return view('admin.index');
    })->where('vue_capture', '[\/\w\.-]*');
});

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::auth();
