<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<header id="header" role="header">
    <img class="uk-border-circle" src="<?=$picture?>" width="90">
    <h3 class="uk-margin uk-margin-small-bottom uk-heading-small uk-text-bold"><?=$username?></h3>
    <div class="uk-text-meta"><?=$description?></div>
</header>
<main id="main" role="main">
    <ul class="uk-list uk-list-divider">
        <?php foreach ($posts as $post) : ?>
        <li>
            <article>
                <h1 class="uk-text-bold">
                    <a href="<?=$post['url']?>" class="uk-link-reset"><?=$post['title']?></a>
                </h1>
                <p class="uk-margin"><?=$post['content']?></p>
                <div class="uk-text-meta">
                    <?=$post['created_at']?>
                </div>
            </article>
        </li>
        <?php endforeach; ?>
    </ul>
</main>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>
