<template>
  <div id="main__form-board">
    <form :action="request_url" method="post" ref="form">
      <input type="hidden" name="_method" :value="method" v-if="method">
      <input type="hidden" name="id" :value="id" v-if="id">
      <input type="hidden" name="token" :value="token">
      <input type="text" name="title" placeholder="Type a post title" class="uk-input uk-article-title" :value="title">
      <hr>
      <div class="editor uk-align-center">
        <textarea name="content" placeholder="Content"></textarea>
        <div id="editor" v-html="content" ref="editor"></div>
      </div>
      <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
  </div>
</template>

<script>
import BalloonEditor from '@ckeditor/ckeditor5-build-balloon-block'

export default {
  props: ['request_url', 'method', 'id', 'token', 'title', 'content'],
  mounted () {
    if (this.$refs.editor instanceof HTMLElement) {
      BalloonEditor.create(this.$refs.editor, {
        ckfinder: {
          uploadUrl: '/image'
        }
      }).then(editor => {
        editor.editing.view.focus()
        this.$refs.form.addEventListener('submit', e => {
          const data = document.createTextNode(editor.getData())
          document.querySelector('#main__form-board textarea[name=content]').appendChild(data)
        })
      })
    }
  }
}
</script>

<style scoped>
#app #main__form-board {
    margin-top: 200px;
    margin-bottom: 75px;
}
#app #main__form-board form > * {
    outline: none;
}
#app #main__form-board form input {
    padding: 0;
    margin: 0 auto;
    display: block;
    width: 550px;
    text-transform: none;
}
#app #main__form-board form textarea {
    display: none;
}
#app #main__form-board form .editor {
    padding: 0;
    margin: 0 auto;
    padding-bottom: 15px;
    display: block;
    width: 550px;
    text-transform: none;
}
#app #main__form-board form .ck.ck-content.ck-editor__editable_inline {
    padding: 0;
    box-sizing: border-box;
    overflow: hidden;
}
#app #main__form-board form .ck.ck-content.ck-editor__editable {
    min-height: 420px;
    border: none;
}
#app #main__form-board form .ck.ck-content.ck-editor__editable.ck-focused {
    border: none;
    box-shadow: none;
}

#app #main__form-board form .uk-article-title {
    margin-bottom: 45px;
    height: 60px;
}
#app #main__form-board form .cke_textarea_inline {
    text-align: left;
    margin: 35px auto;
    min-height: 420px;
}
#app #main__form-board form input:not([type=submit]) {
    border: none;
}
</style>
