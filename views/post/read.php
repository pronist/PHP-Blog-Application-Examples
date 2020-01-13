<?php require_once dirname(__DIR__) . '/layouts/top.php'; ?>

<div id="main__article" class="uk-container">
    <article class="uk-margin uk-article">
        <h1 class="uk-article-title"><?=$title?></h1>
        <div class="uk-text-meta">
            by <?=$username?>
        </div>
        <div class="uk-text-meta">
            <?=$createdAt?>
            <?php if ($isOwner) : ?>
                <span class="owner">
                    <a href="#" class="uk-link-text" id="delete">Delete</a></li>
                    <a href="<?=$update?>" class="uk-link-text" id="update">Update</a></li>
                </span>
            <?php endif; ?>
        </div>
        <div class="uk-text-lead uk-margin-bottom"><?=$content?></div>
    </article>
</div>

<?php require_once dirname(__DIR__) . '/layouts/bottom.php' ?>
