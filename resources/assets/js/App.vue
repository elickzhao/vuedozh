<template>
<div >
  <navbar></navbar>
  <sidebar></sidebar>
</div>
  <div id="app">
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <!-- 这里应该是面包屑的地方 看看如何每个页面都换 -->
      <!-- 缺少图标面包屑 可以参考下 -->
      <!-- 还有就是进入的时候 是空白页 不是跳到home页有展示内容这个也需要改 -->
      <section class="content-header">
        <h1>
          {{$route.name ? $route.name : 'Adminpanel' | uppercase }}
          <small>{{ $route.description ? $route.description : '所有工具都在这里' }}</small>
        </h1>
      </section>

      <!-- Main content -->
      <section class="content">
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
import Sidebar from './components/layouts/Sidebar.vue'



export default {
  components: {
    Navbar,
    Sidebar
  },
  replace: false
}
</script>
