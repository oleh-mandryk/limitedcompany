<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <meta name="description" content=""/>
    <meta name="keywords" content=""/>
    
    <title><?=$site_name?> | <?=$title?></title>   
    
    <link href="/media/img/favicon.ico" rel="shortcut icon" media="screen" />
    <link href="/media/css/print.css" rel="stylesheet" media="print" type="text/css"/>
    
    <?foreach ($styles as $file_style):?>
        <?=html::style($file_style)?>
    <?endforeach?>
    <?foreach ($scripts as $file_script):?>
        <?=html::script($file_script)?>
    <?endforeach?>
</head>
<body>
<div id="wrap">
    <div id="header">
        <h1 id="logo-text">Limited Company</h1>
        <h2 id="slogan">Quality above all...</h2>
        <?if ($auth->logged_in()) {?>
        <div id="header-links">
            <p>
                <?foreach ($menu_top as $mt):?>
                <?if ($select == $mt['url']) {?>
                <?$current = 'id="current"';?>
                <?} else { $current = null;}?>
                <a <?=$current?> title="<?=$mt['name']?>" href="/<?=$mt['url']?>"><?=$mt['name']?></a> |
                <?endforeach?>
                <a title="Exit" href="logout">Exit</a>
            </p>
        </div>
        <?}?>
    </div>
    <?if ($auth->logged_in()) {?>
    <div id="menu">
        <ul>
            <?foreach ($menu_main as $mm):?>
                <?if ($select == $mm['url']) {?>
                <?$current = 'id="current"';?>
                <?} else { $current = null;}?>
                <?if ($menu_main_last == $mm['id']) {?>
                <?$last = 'class="last"';?>
                <?} else { $last = null;}?>
                <li <?=$current?> <?=$last?>><a href="/<?=$mm['url']?>" title="<?=$mm['name']?>"><span><?=$mm['name']?></span></a></li>
            <?endforeach?>
        </ul> 
    </div>
    <?}?>
    <div id="content-wrap">
        <? if (isset($block_content)):?>
        <div id="main">
            <h1><?=$page_title?></h1>
            <?=$block_content?>  
        </div>
        <?endif?>
        <div class="clear"></div>
        <? if (isset($block_auth)):?>
        <div id="contentAuth">
            <?=$block_content?>
        </div>
        <?endif?>
    </div>
    <div id="footer">
        <p> Copyright © 2013 - All Rights Reserved - Limited Company</p>
    </div>
</div>
</body>
</html>