<template>
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
    {{creatingPost}}
      <!-- Sidebar user panel (optional) -->
      <div v-link="{ path: '/profile' }" class="user-panel">
        <div class="pull-left image">
          <img class="profile-user-img img-responsive img-circle"
          :src="user.avatar" alt="User profile picture">
        </div>
        <div class="pull-left info">
          <p>{{user.name}}</p>
          <!-- Status -->
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="pageLink active" @click="toggleMenu"><a v-link="{ path: '/' }"><i class="fa fa-home"></i> <span>Home</span></a></li>
        <!-- Optionally, you can add icons to the links -->
        <li class="treeview" @click="toggleMenu">
          <a href="#">
            <i class="fa fa-list"></i> <span>Posts</span> <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a v-link="{ path: '/posts' }"><i class="fa fa-tasks"></i>Index</a></li>
            <li><a @click="createPost" href="#"><i class="fa fa-keyboard-o"></i>Create post</a></li>
          </ul>
        </li>
        <li class='pageLink' @click="toggleMenu"><a v-link="{ path: '/categories' }"><i class="fa fa-th-large"></i> <span>Categories</span></a></li>
        <li class='pageLink' @click="toggleMenu"><a v-link="{ path: '/users' }"><i class="fa fa-users"></i> <span>Users</span></a></li>
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>
  <div class="control-sidebar-bg"></div>
</template>

<script>
import { stack_bottomright, show_stack_success, show_stack_error, show_stack_info } from '../../Pnotice.js'

export default {
  created() {
    this.fetchUser()
  },
  data () {
    return {
      user: {}
    }
  },
  computed: {
    creatingPost: function () {
      return this.$route.name === 'editpost'
    }
  },
  methods: {
    fetchUser () {
      this.$http({url: '/api/me', method: 'GET'}).then(function (response) {
        this.$set('user', response.data)
      })
    },
    createPost () {
      if( !this.creatingPost ){
        this.$http({url: '/api/posts', method: 'POST'}).then(function (response) {
          show_stack_info('Creating post...', response)
          this.$router.go('/posts/'  + response.data.hashid + '/edit')
        }, function (response){
               show_stack_error('Failed to create post!', response)
             })
      } else {
        swal('Sorry', 'Please navigate elsewhere before creating new post.', 'info')
      }
    },
    toggleMenu: function (event) {  //这个激活状态还是有问题,有时显示有时不显示,暂时先这样吧
      // remove active from li
      window.$('li.pageLink').removeClass('active')
      // Add it to the item that was clicked
      event.toElement.parentElement.className = 'pageLink active'
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1 {
  color: #42b983;
}
aside {
  height: 2100px;
}
.user-panel {
  cursor: pointer;
}
</style>
