<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>A simple blog application example for PHP 7+</title>

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
                        <li><a href="/user/register.php">Register</a></li>
                            <?php if ($user) : ?>
                                <li><a href="/user/update.php">My page</a></li>
                                <li><a href="/post/write.php">Write</a></li>
                                <li><a href="#" id="logout">Sign out</a></li>
                            <?php else : ?>
                                <li><a href="/login.php">Sign in</a></li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </nav>
                <main id="main" role="main">
