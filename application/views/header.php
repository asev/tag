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
        <?php echo anchor('', '<img src="/img/tag_logo.png" alt="logo">'); ?>
    <?php if (!is_null($me)) :?><p class="logout"><?php echo $me . ' |'; ?>
        <?php echo anchor('auth/logout',"Atsijungti"); ?></p>
            </div>
    <div id="meniu">
        <ul>
        <li class="border"><?php echo anchor('main','Pradžia'); ?></li>
        <li class="border"><?php echo anchor('reqs/current', 'Užklausos'); ?></li>
        <li class="border"><?php echo anchor('reqs/past','Istorija'); ?></li>
        <li class="border"><?php echo anchor('reqs/spam','Šlamštas'); ?></li>
        <li class="border-none"><?php echo anchor('req/show/last', 'Laukia '. ' '.$waiting); ?></li>
        </ul>
        <div class="search">
            <?php echo form_open('main');
            echo form_input('search', set_value('search'));
            echo form_submit($submit);
            echo form_close(); ?>
        </div>
    </div>
        <div class="tag-logo">
        <?php else : ?>
    <p class="login"><?php echo anchor('auth/',"Prisijungti"); ?></p>
<?php endif;?>
        </div>
</div>
    <div id="content">
