import Vue from 'vue'

import Nav from './components/nav.vue'
import Index from './components/index.vue'
import AuthForm from './components/authForm.vue'
import PostForm from './components/postForm.vue'
import Read from './components/read.vue'

Vue.component('app-nav', Nav)
Vue.component('app-index', Index)
Vue.component('app-auth-form', AuthForm)
Vue.component('app-post-form', PostForm)
Vue.component('app-read', Read)

new Vue({ el: '#app' })
