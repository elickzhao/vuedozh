import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import VueResource from 'vue-resource'


Vue.use(VueRouter)

Vue.use(VueResource)

/* eslint-disable no-new */

var router = new VueRouter({
    history: true,
    root: 'dashboard'
})

router.map({
    // 这样写子路由的确出来了 不过还是得点那下菜单 要不还是和下面一样没有 '/' 这个
    // '/':{
    //     component: require('./App.vue'),
    //     name: 'main',
    //     description: '框架',
    //     subRoutes: {
    //             '/': {  //首页即是home页怎么搞也没办法了 只能把home页内容放到app.vue的里 因为直接过来的是laravel路由指定的 默认去掉了后面的/
    //                 component: require('./components/Home.vue'),
    //                 name: 'home',
    //                 description: "这里是主页" 
    //             },
    //     }
    // },
    // '': {  //首页即是home页怎么搞也没办法了 只能把home页内容放到app.vue的里 因为直接过来的是laravel路由指定的 默认去掉了后面的/
    //     component: require('./components/Home.vue'),
    //     name: 'home',
    //     description: "这里是主页" 
    // },
    '/posts/': {
        component: require('./components/Posts.vue'),
        name: 'posts',
        description: "文章" 
    },
    '/posts/categories/:hashid': {
        name: 'postincats',
        component: require('./components/Posts.vue'),
        description: "文章分类" 
    },
    '/posts/:hashid/edit': {
        name: 'editpost',
        component: require('./components/Editpost.vue'),
        description: "编辑文章" 
    },
    '/users': {
        component: require('./components/Users.vue'),
        name: 'users',
        description: "用户列表" 
    },
    '/categories': {
        component: require('./components/Categories.vue'),
        name: 'categories',
        description: "分类列表" 
    },
    '/categories/:hashid/edit': {
        name: 'categories',
        component: require('./components/Editcategory.vue'),
        description: "编辑分类列表" 
    },
    '/profile': {
        component: require('./components/Profile.vue'),
        name: 'profile',
        description: "用户信息" 
    },
})

router.alias({

    // alias can contain dynamic segments
    // the dynamic segment names must match
    '/posts/:hashid': '/posts/:hashid/edit',
    'categories/:hashid': '/categories/:hashid/edit'
})

router.start(App, 'body')
