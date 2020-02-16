<div id="main__article" class="uk-container">
    <article class="uk-margin uk-article">
        <h1 class="uk-article-title"><?=$post['title']?></h1>
        <div class="uk-text-meta">
            by <?=$username?>
        </div>
        <div class="uk-text-meta">
            <?=$post['created_at']?>
            <?php if (owner($id)) : ?>
                <span class="owner">
                    <a href="/post/delete.php?id=<?=$post['id']?>&token=<?=$_SESSION['CSRF_TOKEN']?>" class="uk-link-text" id="delete">Delete</a>
                    <a href="/post/update.php?id=<?=$post['id']?>" class="uk-link-text" id="delete">Update</a>
                </span>
            <?php endif; ?>
        </div>
        <div class="uk-text-lead uk-margin-bottom"><?=$post['content']?></div>
    </article>
</div>
