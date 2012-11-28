<?php
$submit = array(
    'name'	=> 'submit',
    'class'	=> 'submit',
);
?>

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
    </div>
    <div id="meniu">
        <ul>
        <li><a href="">Pradžia</a></li>
        <li><a href="">Užklausos</a></li>
        <li><a href="">Istorija</a></li>
        <li><a href="">Šlamštas</a></li>
        </ul>
        <div class="search">
            <?php echo form_open('');
            echo form_input('search', set_value('search'));
            echo form_submit($submit);
            echo form_close(); ?>
        </div>
    </div>
</div>
    <div id="content">