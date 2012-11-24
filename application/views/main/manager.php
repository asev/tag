<?php
?>
<div id="main-manager">
        Vadybininko langas.
        Laukia: <?php echo $waiting;?>
    <?php if ($waiting > 0) echo anchor('req/last','Paskutinė užklausa'); ?>
    </div>
    <?php anchor('reqs/current', "Mano užklausos"); ?><br>
    <?php anchor('reqs/past', "Mano atliktos užklausos"); ?><br>
    <?php anchor('reqs/spam', "Šlamštas"); ?><br>

    <div id="search">
        <?php echo form_open('');
        echo form_input('search', set_value('search'));
        echo form_submit('submit', "Ieškoti");
        echo form_close(); ?>
    </div>