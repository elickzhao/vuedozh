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
    '/': {  //改成空格也不对 //明天把这里改下测试一下 //结果今天又没搞懂
        component: require('./components/Home.vue'),
        name: 'home',
        description: "这里是主页" 
    },
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
