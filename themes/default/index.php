<!DOCTYPE html>
<html lang="<?=$html_lang?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?=$title?></title>
        <link rel="icon" type="image/x-icon" href="favicon.ico" />
        <link rel="stylesheet" type="text/css" href="assets/css/style.min.css?v=<?=$debug ? time() : $version?>">
        <?=$user_css?>
    </head>
    <body class="<?=$body_class?>">
        <header>
            <h1><a href="<?=$uri?>"><?=$software_name?></a></h1>
            <?=$add_button?>
            <nav>
            <?=$dashboard_button?>
            <?=$list_of_views?>
            <?=$settings_button?>
            </nav>
<!--             <?=$export_button_pdf?> -->
            <?=$export_button_csv?>
            <?=$searchbox?>
            <?=$list_of_editable_tables?>
        </header>
        <main>
            <h2><?=$page_name?></h2>
            <p class="date_now"><?=$date_now?></p>
            <?=$error?>
            <?=$content?>
        </main>
            <footer class="center">
            <p><?=$slogan?></p>
            <?=$language_button?>
<!--             <p><a href="https://github.com/raffaelj/eeks">Sourcecode on Github</a></p> -->
<!--             <p><?=$version?></p> -->
        </footer>
        <?=$js?>
    </body>
</html>
