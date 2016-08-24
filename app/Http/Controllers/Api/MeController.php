<?php

namespace App\Http\Controllers\Api;

use App\Transformers\UserTransformer;
use Hash;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class MeController extends ApiController
{
    protected $user;

    /**
     * CategoriesController constructor.
     *
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(Request $request)
    {
//        $this->middleware('authorized:manage-category,categories', ['except' => ['index', 'show']]);;
        //dump($request->user());
        $this->user = $request->user(); //应该是5.2新增的获取当前用户
    }

    /**
     * Display the specified resource.
     * @return \Response
     */
    public function show()
    {
        //$user = User::get();
        //dump($user);
        //其实直接用laravel返回json也可以,不过有些多余字段去除和增加数据库没有的字段比较麻烦 比如这里的头像 数据库是没有的
        //所以用fractal比较简单 只要自定义模板 UserTransformer 就可以了.格式化输出json.但是结果都放在data下
        //return response()->json($user);  
        //return $this->respondWith($user, new UserTransformer);
        //------------------上面是pc测试
        return $this->respondWith($this->user, new UserTransformer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(Request $request)
    {
        //check that user has provided his current password
        if($request->has('password') && Hash::check($request->get('password'), $this->user->password)){
            $this->validate($request, [
                'email' => 'email|max:255|unique:users,email,'.$this->user->id,
                'username' => 'max:50|unique:users,username,'.$this->user->id,
                'name' => 'max:255',
                'new_password' => 'min:6|confirmed'
            ]);

            $this->user->fill($request->all());
            
            if($request->get('new_password')){
                $this->user->password = bcrypt($request->get('new_password'));
            }
            
            $this->user->save();

            return $this->respondWith($this->user, new UserTransformer);
        } else {
            return $this->errorUnauthorized('Invalid current password.');
        }
    }
}
