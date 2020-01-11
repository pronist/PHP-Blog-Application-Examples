<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<main id="main" role="main" class="uk-padding-small">
    <article class="uk-margin uk-article">
        <h1 class="uk-article-title"><?=$title?></h1>
        <div class="uk-text-meta uk-margin-large-bottom"><?=$createdAt?></div>
        <div class="uk-text-lead uk-margin-bottom"><?=$content?></div>
        <?php if ($isOwner) : ?>
            <a href="#" class="uk-link-text uk-margin-small-right" id="delete">Delete</a></li>
            <a href="<?=$update?>" class="uk-link-text" id="update">Update</a></li>
        <?php endif; ?>
    </article>
    <div class="uk-card">
        <hr>
        <div class="uk-card-header uk-padding-remove-horizontal">
            <div class="uk-grid-small uk-flex-middle" uk-grid>
                <div class="uk-width-auto">
                    <img class="uk-border-circle" width="48" height="48" src="<?=$picture?>">
                </div>
                <div class="uk-width-expand">
                    <h3 class="uk-card-title">
                        <a class="uk-link-reset uk-text-bold" href="/board/list.php?user=<?=$username?>"><?=$username?></a>
                    </h3>
                    <p class="uk-text-meta uk-margin-remove-top"><?=$description?></p>
                </div>
            </div>
        </div>
        <hr>
    </div>
</main>

<script>
    let $delete = document.getElementById('delete');
    if ($delete) {
        $delete.addEventListener('click', e => {
            e.preventDefault();
            axios.delete("/board/delete.php", {
                data: {
                    id: <?=$id?>
                }
            }).then(() => {
                location.href = '/board/list.php?user=' + '<?=$username?>';
            })
        })
    }
</script>

<?php require_once dirname(__DIR__) . '/layouts/footer.php' ?>
