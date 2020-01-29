<template>
  <nav id="nav" role="navigation" class="uk-navbar-container uk-navbar-transparent uk-padding uk-padding-remove-vertical uk-margin-bottom" uk-navbar>
    <div class="uk-navbar-right">
        <ul class="uk-navbar-nav">
          <li><a href="/">Home</a></li>
          <li><a href="/user/register">Register</a></li>
          <template v-if="user">
            <li><a href="/user/update">My page</a></li>
            <li><a href="/post/write">Write</a></li>
            <li><a href="#" @click="logout">Sign out</a></li>
          </template>
          <template v-else>
            <li><a href="/auth/login">Sign in</a></li>
          </template>
        </ul>
    </div>
  </nav>
</template>

<script>
export default {
  props: ['user'],
  methods: {
    logout () {
      fetch('/auth/logout', { method: 'post' }).then(response => {
        if (response.ok) {
          location.href = '/'
        }
      })
    }
  }
}
</script>

<style scoped>
#app #nav a {
    text-transform: none;
}
</style>
