/* global BalloonEditor, id, token */

/**
 * Auth: Logout
 *
 * @return {void}
 */
function logout () {
  fetch('/logout.php', { method: 'post' }).then(response => {
    if (response.ok) {
      location.href = '/'
    }
  })
}

/**
 * /logout.php
 */
const $logout = document.getElementById('logout')
if ($logout instanceof HTMLElement) {
  $logout.addEventListener('click', e => {
    e.preventDefault()
    logout()
  })
}

/**
 * Request append posts
 *
 * @param {string} to
 * @param {number} page
 *
 * https://developer.mozilla.org/en-US/docs/Web/API/DOMParser
 */
function append (to, page) {
  fetch('/?page=' + page, { method: 'get' })
    .then((response) => response.text())
    .then((html) => {
      const parser = new DOMParser()
      const doc = parser.parseFromString(html, 'text/html')
      const container = doc.querySelector('.uk-list')
      if (container.querySelectorAll('li').length > 0) {
        document.querySelector(to).appendChild(container)
      }
    })
}

/**
 * Request remove a post
 *
 * https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API
 */
function remove () {
  fetch('/post/?id=' + id, {
    method: 'delete',
    body: JSON.stringify({ token })
  }).then(() => {
    location.href = '/'
  })
}

/**
 * Render CKEditor 5
 *
 * https://ckeditor.com/ckeditor-5/
 *
 * @param {HTMLElement} $editor
 */
function editor ($editor) {
  return BalloonEditor.create($editor, {
    ckfinder: {
      uploadUrl: '/image/'
    }
  })
}

/**
 * /post -> post/index.php
 */
const $readMore = document.getElementById('readmore')
if ($readMore instanceof HTMLElement) {
  let page = 0
  $readMore.addEventListener('click', () => {
    append('.uk-container', ++page)
  })
}

/**
 * /post/?id={id} -> post/index.php
 */
const $delete = document.getElementById('delete')
if ($delete instanceof HTMLElement) {
  $delete.addEventListener('click', e => {
    e.preventDefault()
    remove()
  })
}

/**
 * post/write.php, post/update.php
 */
const $editor = document.getElementById('editor')
const $form = document.getElementById('main__form-board')
if ($editor instanceof HTMLElement) {
  editor($editor).then(editor => {
    editor.editing.view.focus()
    $form.addEventListener('submit', e => {
      const data = document.createTextNode(editor.getData())
      document.querySelector('#main__form-board textarea[name=content]').appendChild(data)
    })
  })
}
