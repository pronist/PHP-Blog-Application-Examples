<?php require_once 'layouts/header.php' ?>

<main id="main" role="main">
    <ul class="uk-list uk-list-divider">
        <?php foreach ($posts as $post) : ?>
        <li>
            <article>
                <h1>
                    <a href="<?=$post['url']?>" class="uk-link-reset"><?=$post['title']?></a>
                </h1>
                <div class="uk-text-meta">
                    by
                    <a href="<?=$post['author']?>" class="uk-link-text">
                        <?=$post['username']?>
                    </a>
                </div>
                <p class="uk-margin"><?=$post['content']?></p>
                <div class="uk-text-meta">
                    <?=$post['created_at']?>
                </div>
            </article>
        </li>
        <?php endforeach; ?>
    </ul>
</main>

<?php require_once 'layouts/footer.php' ?>
