<?php require_once dirname(__DIR__) . '/layouts/header.php'; ?>

<header id="header" role="header">
    <img class="uk-border-circle" src="<?=$picture?>" width="90">
    <h3 class="uk-margin uk-margin-small-bottom uk-heading-small uk-text-bold"><?=$username?></h3>
    <div class="uk-text-meta"><?=$description?></div>
</header>
<main id="main" role="main">
    <div class="uk-container">
        <?php require_once dirname(__DIR__) . '/layouts/list.php'; ?>
    </div>
</main>

<?php require_once dirname(__DIR__) . '/layouts/footer.php'; ?>

