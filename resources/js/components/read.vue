<template>
  <div id="main__article" class="uk-container">
    <article class="uk-margin uk-article">
      <h1 class="uk-article-title">{{ title }}</h1>
      <div class="uk-text-meta">
          by {{ username }}
      </div>
      <div class="uk-text-meta">
        {{ created_at }}
        <span class="owner" v-if="is_owner">
          <a href="#" class="uk-link-text" id="delete" @click="remove">Delete</a>
          <a :href="update" class="uk-link-text" id="update">Update</a>
        </span>
      </div>
      <div class="uk-text-lead uk-margin-bottom" v-html="content"></div>
    </article>
  </div>
</template>

<script>
export default {
  props: ['id', 'token', 'title', 'content', 'username', 'created_at', 'is_owner', 'update'],
  methods: {
    remove () {
      fetch('/post/' + this.id, {
        method: 'delete',
        body: JSON.stringify({ token: this.token })
      }).then(() => {
        location.href = '/'
      })
    }
  }
}
</script>

<style scoped>
#app #main__article > .uk-article .owner {
    margin-left: 5px;
}
#app #main__article > .uk-article .owner > a {
    margin: 0 2px;
}
#app #main__article > .uk-article .uk-article-title {
    font-size: 1.5em;
}
#app #main__article > .uk-article .uk-text-meta {
    margin-bottom: 20px;
}
#app #main__article > .uk-article .uk-text-lead h2 {
    font-weight: 400;
    margin-bottom: 15px;
    font-size: 1.4em;
    font-weight: 500;
}
#app #main__article > .uk-article .uk-text-lead h3 {
    font-weight: 500;
    margin-top: 25px;
    margin-bottom: 20px;
    font-size: 1.2em;
}
#app #main__article > .uk-article .uk-text-lead h4 {
    font-weight: 500;
    margin-bottom: 5px;
    font-size: 1.1em;
}
#app #main__article > .uk-article .uk-text-lead p {
    margin-bottom: 15px;
    color: rgba(0,0,0,0.85);
    line-height: 1.9em;
}
#app #main__article > .uk-article .uk-text-lead b {
    color: #ed5207;
    font-weight: 500;
}
#app #main__article > .uk-article .uk-text-lead a {
    color: #000;
    box-shadow: inset 0 -2px 0 #fcdae9;
    transition: all .35s;
    transition-timing-function: cubic-bezier(.7, 0, .3, 1);
    text-decoration: none;
}
#app #main__article > .uk-article .uk-text-lead a:hover {
    box-shadow: inset 0 -20px 0 #fcdae9;
}
#app #main__article > .uk-article .uk-text-lead pre {
    border-radius: 5px;
}
#app #main__article > .uk-article .uk-text-lead blockquote {
    border-color: #acacac;
    border-width: 0 0 0 2px;
    border-style: solid;
    padding: 1px 0 0 12px;
    color: #666;
    line-height: 1.8em;
    text-align: left;
    font-size: 0.9em;
}
#app #main__article .uk-article .uk-text-lead blockquote p {
    margin: 0;
}
</style>
