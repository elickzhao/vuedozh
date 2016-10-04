<template>
<div >
  <navbar></navbar>
  <sidebar></sidebar>
</div>
  <div id="app">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- 还有就是进入的时候 是空白页 不是跳到home页有展示内容这个也需要改 -->
      <!-- 还有个问题是ｇｕｌｐ如何直接观察变化的问题　要不每次都得生成文件才能看到结果 -->
      <!-- 增加了 laravel备份插件 考试过了 这两个可以写了 不过今天得休息 今天还得睡 -->
      <section class="content-header">
        <h1>
          {{$route.name ? $route.name : 'Adminpanel' | uppercase }}
          <small>{{ $route.description ? $route.description : '所有工具都在这里' }}</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
          <li class="active">{{$route.name | uppercase }}</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
      <!-- 终于ok了 这样跳转过来就能看到home页了 -->
      <!-- 还有记住 变量未赋值是void 而不能用空 也就是这个'' 这样不成立 -->
      <!-- 还有双括号那个if 不知道为啥怎么写都直接输出 好像不好用 不知道是不是版本问题 反正只能用v-if这么写了 -->
      <home v-if="$route.name==viod"></home>

        <!-- Your Page Content Here -->
        <!-- route outlet -->
        <router-view></router-view>
      </section>
      <!-- /.content -->
    </div>
  </div>
</template>


<script>
import Navbar from './components/layouts/Navbar.vue'
import Sidebar from './components/layouts/Sidebar.vue'  //这里有问题 当前选定的菜单不是激活状态 只是下拉菜单是有激活状态
import Home from './components/Home.vue'



export default {
  components: {
    Navbar,
    Sidebar,
    Home
  },
  replace: false
}
</script>
