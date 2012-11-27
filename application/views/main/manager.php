<?php
?>
<div id="main-manager">
        Vadybininko <?php echo $username; ?> langas.
        Laukia: <?php echo $waiting;?>
    <?php if ($waiting > 0) echo anchor('req/last','Paskutinė užklausa'); ?>
    </div><div>
    <?php echo anchor('reqs/current', "Mano užklausos"); ?><br>
    <?php echo anchor('reqs/past', "Mano atliktos užklausos"); ?><br>
    <?php echo anchor('reqs/spam', "Šlamštas"); ?><br>
</div>
    <div id="search">
        <?php echo form_open('');
        echo form_input('search', set_value('search'));
        echo form_submit('submit', "Ieškoti");
        echo form_close(); ?>
    </div>