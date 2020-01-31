<?php
require_once dirname(__DIR__) . '/bootstrap/app.php';

if (!array_key_exists('user', $_SESSION)) {
    return header('Location: /auth/login.php');
}

$_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32));
?>

<?php require_once dirname(__DIR__) . '/layouts/top.php'; ?>

<div id="main__form-post">
    <form action="/post/write_process.php" method="post" id="form">
      <input type="hidden" name="token" value="<?=$_SESSION['CSRF_TOKEN']?>">
      <input type="text" name="title" placeholder="Type a post title" class="uk-input uk-article-title">
      <hr>
      <div class="editor uk-align-center">
            <textarea name="content" placeholder="Content"></textarea>
            <div id="editor"></div>
      </div>
      <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once dirname(__DIR__) . '/layouts/bottom.php'; ?>

