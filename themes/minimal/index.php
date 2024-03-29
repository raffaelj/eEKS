<!DOCTYPE html>
<html lang='<?=$lang?>'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title><?=$title?></title>
        <link rel='icon' type='image/x-icon' href='favicon.ico' />
        <link rel='stylesheet' type='text/css' href='css/style.min.css?v=<?=$debug ? time() : $version?>'>
        <?=$user_css?>
    </head>
    <body class='<?=$body_class?>'>
        <header>
            <h1><a href='<?=$uri?>'><?=$software_name?></a></h1>
            <?=$add_button?>
            <?=$export_button_csv?>
            <?=$searchbox?>
        </header>
        <main>
            <?=$error?>
            <?=$content?>
        </main>
    </body>
</html>
