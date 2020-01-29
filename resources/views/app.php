<!DOCTYPE html>

<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>phpblog - <?=$_SERVER['REQUEST_URI'] ?? ''?></title>

        <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans+KR:400,500&display=swap&subset=korean">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/css/uikit.min.css" />
        <link rel="stylesheet" href="/app.css">
        <style>
            *, *::before, *::after {
                margin: 0;
                padding: 0;
                font-family: 'Noto Sans KR', sans-serif !important;
                box-sizing: border-box;
            }
            p {
                line-height: 1.8em;
                color: rgba(0, 0, 0, .6);
            }
            main {
                margin: 0 auto;
            }
            #app .uk-container {
                width: 550px;
                margin: 35px auto;
            }
        </style>
    </head>
    <body>
        <div id="app" class="uk-container-expand">
            <app-nav user = '<?=user() ? true : false?>'></app-nav>
            <main id="main" role="main">
                <?=$componentString?>
            </main>
        </div> <!-- #app -->
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.2.6/dist/js/uikit-icons.min.js"></script>
        <script src="/app.js"></script>
    </body>
</html>
