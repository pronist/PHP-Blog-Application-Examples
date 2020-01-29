<template>
  <div id="main__form-auth" class="uk-padding uk-position-fixed uk-position-center">
    <form :action="request_url" method="post">
      <input type="hidden" name="_method" :value="method" v-if="method">
      <input type="hidden" name="token" :value="token">
      <input type="text" name="email" placeholder="Email" :value="email" class="uk-input">
      <input type="password" name="password" placeholder="Password" class="uk-input">
      <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
  </div>
</template>

<script>
export default {
  props: ['request_url', 'method', 'token', 'email']
}
</script>

<style scoped>
#app #main__form-auth form > * {
    margin: 15px 0;
    font-size: .85em;
    text-transform: none;
}
#app #main__form-auth {
    width: 320px;
    text-align: center;
    box-sizing: border-box;
}
#app #main__form-auth form > input:not([type=submit]) {
    border: none;
    border-bottom: 1px solid rgba(0, 0, 0, .1);
}
</style>
