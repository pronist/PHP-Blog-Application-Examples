<?php require_once dirname(__DIR__) . '/layouts/top.php' ?>

<div id="main__form-board">
    <form action="<?=$requestUrl?>" method="post">
        <?php if (isset($method) && isset($id)) : ?>
            <input type="hidden" name="_method" value="<?=$method?>">
            <input type="hidden" name="id" value="<?=$id?>">
        <?php endif; ?>
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="text" name="title" placeholder="Type a post title" class="uk-input uk-article-title" value="<?=$title ?? ''?>">
        <hr>
        <div class="editor uk-align-center">
            <textarea name="content" placeholder="Content"></textarea>
            <div id="editor"><?=$content ?? ''?></div>
        </div>
        <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once dirname(__DIR__) . '/layouts/bottom.php' ?>
