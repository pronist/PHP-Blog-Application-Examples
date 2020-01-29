<template>
  <div id="main__index" class="uk-container">
    <ul class="uk-list">
      <li v-for="(post, idx) in postsData" :key="idx" >
        <article class="uk-article">
          <h1 class="uk-article-title">
            <a :href="post.url" class="uk-link-reset">{{ post.title }}</a>
          </h1>
          <div class="uk-text-meta">by {{ post.username }}</div>
          <p class="uk-margin">{{ post.content }}</p>
          <div class="uk-text-meta">{{ post.created_at }}</div>
        </article>
        <hr />
      </li>
    </ul>
    <button id="readmore" class="uk-button uk-button-default" @click="readmore">Read more</button>
  </div>
</template>

<script>
export default {
  props: ['posts'],
  data () {
    return { postsData: JSON.parse(this.posts), page: 0 }
  },
  methods: {
    async readmore () {
      const posts = await fetch('/post?page=' + ++this.page, { method: 'get' })
        .then(async response => {
          const data = await response.text()
          return JSON.parse(data)
        })
      this.postsData = this.postsData.concat(posts)
    }
  }
}
</script>

<style>
#app article > h1 {
    font-weight: bold;
}
#app article .uk-text-meta {
    font-size: .8em;
    color: rgba(0, 0, 0, .4);
}
#app article .uk-text-lead {
    font-size: 1em;
}
</style>

<style scoped>
#app #main__index article h1 {
    font-size: 1.25em;
}
#app #main__index article {
    padding: 25px 0;
}
</style>

<style scoped>
#app #readmore {
    text-transform: none;
    margin: 0 auto;
    display: block;
    margin-bottom: 35px;
    width: 550px;
}
</style>
