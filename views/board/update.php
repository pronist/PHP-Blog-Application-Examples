<?php require_once dirname(__DIR__) . '/layouts/header.php' ?>

<main id="main" role="main">
    <div id="main__form-board">
        <form action="/board/update_process.php" method="post">
            <input type="hidden" name="_method" value="patch">
            <input type="hidden" name="token" value="<?=$token?>">
            <input type="hidden" name="id" value="<?=$id?>">
            <input type="text" name="title" placeholder="Type a post title" class="uk-input uk-article-title" value="<?=$title?>">
            <hr>
            <textarea name="content" placeholder="Content" id="editor" contenteditable="true"><?=$content?></textarea>
            <input type="submit" value="Update a post" class="uk-button uk-button-default uk-width-1-1">
        </form>
    </div>
</main>

<?php require_once dirname(__DIR__) . '/layouts/footer.php' ?>
