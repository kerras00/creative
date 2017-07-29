<!doctype html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Creative</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Ubuntu:300">
    <link rel="stylesheet" href="/assets/css/styles.css">
</head>
    <body>
        <div class="flex-center position-ref full-height">
              <div class="content">
                
                {if strpos($view_html , ".tpl") == true}
                    {include file=$view_html}
                {else}
                    {$view_html}
                {/if}

            </div>
        </div>
    </body>
</html>