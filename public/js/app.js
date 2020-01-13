/**
 * Logout
 */
function logout() {
  fetch('/logout.php', {
    method: 'post'
  })
  .then(() => location.href = '/');
}

/**
 * Request pppend posts
 *
 * @param {string} to
 *
 * https://developer.mozilla.org/en-US/docs/Web/API/DOMParser
 */
function append(to) {
  let page = 0;
  fetch('/?page=' + ++page, {
    method: 'get'
  })
  .then((response) => response.text())
  .then((html) => {
    let doc = (new DOMParser).parseFromString(html, "text/html");
    let container = doc.querySelector('.uk-list');
    if (container.querySelectorAll('li').length > 0) {
      document.querySelector(to).appendChild(container);
    }
  });
}

/**
 * Request remove a post
 *
 * @param {number} id
 * @param {string} token
 *
 * https://developer.mozilla.org/en-US/docs/Web/API/Fetch_API
 */
function remove(id, token) {
  fetch("/post/?id=" + id, {
    method: 'delete',
    body: JSON.stringify({ token })
  })
  .then(() => location.href = '/');
}

/**
 * Render CKEditor 4
 *
 * https://ckeditor.com/ckeditor-4/
 *
 * @param {string} selector
 */
function editor(selector) {
  CKEDITOR.inline(selector, {
    extraPlugins: 'image2, uploadimage',
    uploadUrl: '/image/'
  });
  CKEDITOR.instances.editor.on('instanceReady', function (event) {
    CKEDITOR.instances.editor.focus();
  });
}

window.addEventListener('load', () => {
  /**
   * /logout.php
   */
  let $logout = document.getElementById('logout');
  if ($logout instanceof HTMLElement) {
    $logout.addEventListener('click', e => {
      e.preventDefault();
      logout();
    });
  }
  /**
   * /post -> post/index.php
   */
  let $readMore = document.getElementById('readmore');
  if ($readMore instanceof HTMLElement) {
    $readMore.addEventListener('click', () => {
      append('.uk-container');
    });
  }
  /**
   * /post/?id={id} -> post/index.php
   */
  let $delete = document.getElementById('delete');
  if ($delete instanceof HTMLElement && id && token) {
    $delete.addEventListener('click', e => {
      e.preventDefault();
      remove(id, token);
    });
  }
 /**
   * post/write.php, post/update.php
   */
  if (document.getElementById('editor') instanceof HTMLElement) {
    editor('editor');
  }
});

