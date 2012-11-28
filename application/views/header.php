<!DOCTYPE html>
<html>
<head>
    <title>TAG</title>
    <link type="text/css" rel="stylesheet" href="<?php echo base_url();?>/css/style.css">
    <meta charset="UTF-8">
</head>

<body>
<div id="layout">
<div id="header">
    <div class="tag-logo">
        <img src="/img/tag_logo.png" alt="logo">

    </div><?php if (!is_null($me)) :?> <p><?php echo $me; ?> |
    <?php echo anchor('auth/logout',"Atsijungti"); ?></p>
    <?php echo $waiting; ?>
    <div id="meniu">
        <h2><a href="">Pradžia</a></h2>
        <p>|</p>
        <h2><a href="">Užklausos</a></h2>
        <p>|</p>
        <h2><a href="">Istorija</a></h2>
        <p>|</p>
        <h2><a href="">Šlamštas</a></h2>
        <div class="search">
        <input type="text" name="search">
            <button type="button"></button>
        </div>
    </div>
        <?php endif;?>
</div>
    <div id="content">