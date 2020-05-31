<?php $_SESSION['CSRF_TOKEN'] = bin2hex(random_bytes(32)) ?>

<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>phpblog - <?=$_SERVER['REQUEST_URI'] ?? ''?></title>

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans+KR:400,500&display=swap&subset=korean">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/css/uikit.min.css" />
        <link rel="stylesheet" href="/app.css">
    </head>
    <body>
        <div id="app" class="uk-container-expand">
            <nav id="nav" role="navigation" class="uk-navbar-container uk-navbar-transparent uk-padding uk-padding-remove-vertical uk-margin-bottom" uk-navbar>
                <div class="uk-navbar-right">
                    <ul class="uk-navbar-nav">
                        <li><a href="/">Home</a></li>
                        <li><a href="/users/register">Register</a></li>
                        <?php if (array_key_exists('user', $_SESSION)) : ?>
                            <li><a href="/posts/write">Write</a></li>
                            <li><a href="#" id="logout">Sign out</a></li>
                        <?php else : ?>
                            <li><a href="/auth/login">Sign in</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>
            <main id="main" role="main">
                <?php require_once dirname(__DIR__) . '/' . $view . '.php' ?>
            </main>
        </div> <!-- #app -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit-icons.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/balloon-block/ckeditor.js"></script>
        <script>
            const $logout = document.getElementById('logout')
            if ($logout instanceof HTMLElement) {
                $logout.addEventListener('click', () => {
                    fetch('/auth/logout', { method: 'post' }).then(() => window.location.reload())
                })
            }
            const $editor = document.getElementById('editor')
            if ($editor instanceof HTMLElement) {
                BalloonEditor.create($editor, {
                    ckfinder: {
                        uploadUrl: '/images'
                    }
                }).then(editor => {
                    editor.editing.view.focus()
                    const $form = document.querySelector('#main__form-post > form')
                    $form.addEventListener('submit', e => {
                        const data = document.createTextNode(editor.getData())
                        document.querySelector('#main__form-post textarea[name=content]').appendChild(data)
                    })
                })
            }
        </script>
    </body>
</html>

