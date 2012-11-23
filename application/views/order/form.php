<?php   //@toGin paruošti formą pagal duombazę. Įvedamas kodas, pavadinimas, kaina ir kiekis
        // Sito daryti neskubek. Tikriausiai bus keitimų
?>
<div id="order-form">
    <?php echo validation_errors(); ?>
    <?php echo form_open(''); ?>
    <input type="text" name="full-name" value="" size="50" />
    <input type="text" name="email" value="" size="50" />
    <input type="text" name="phone" value="" size="50" />
    <input type="text" name="request-text" value="" size="50" />
    <input type="submit" />
    <?php echo form_close(); ?>
</div>