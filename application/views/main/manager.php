<?php //@todo pabaigti ir priskirtirti Gintarei Grazus vaizdavimas
?>
<div id="main-manager">
        Vadybininko langas.
        Laukia: <?php echo $waiting;?>
    <?php if ($waiting > 0) echo anchor('req/last','Paskutinė užklausa'); ?>
    </div>