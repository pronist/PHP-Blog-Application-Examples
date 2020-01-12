<ul class="uk-list uk-list-divider">
    <?php foreach ($posts as $post) : ?>
        <li>
            <article>
                <h1 class="uk-article-title">
                    <a href="<?=$post['url']?>" class="uk-link-reset"><?=$post['title']?></a>
                </h1>
                <div class="uk-text-meta">
                    by
                    <a href="<?=$post['author']?>" class="uk-link-text">
                        <?=$post['username']?>
                    </a>
                </div>
                <?php if ($post['thumbnail']): ?>
                    <div class="uk-margin"><?=$post['thumbnail']?></div>
                <?php endif; ?>
                <p class="uk-margin"><?=$post['content']?></p>
                <div class="uk-text-meta">
                    <?=$post['created_at']?>
                </div>
            </article>
        </li>
    <?php endforeach; ?>
</ul>
