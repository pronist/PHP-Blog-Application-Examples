<?php require_once dirname(__DIR__) . '/layouts/top.php'; ?>

<div id="main__form-auth" class="uk-padding uk-position-fixed uk-position-center">
    <form action="<?=$requestUrl?>" method="post">
        <?php if (isset($method)) : ?>
            <input type="hidden" name="_method" value="<?=$method?>">
        <?php endif; ?>
        <input type="hidden" name="token" value="<?=$token?>">
        <input type="text" name="email" placeholder="Email" value="<?=$email ?? ''?>" class="uk-input">
        <input type="password" name="password" placeholder="Password" class="uk-input">
        <input type="submit" value="Submit" class="uk-button uk-button-default uk-width-1-1">
    </form>
</div>

<?php require_once dirname(__DIR__) . '/layouts/bottom.php'; ?>
