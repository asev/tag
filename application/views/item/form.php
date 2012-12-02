<?php

$itemId = array(
    'name'  => 'item-id',
    'id'    => 'item-id',
    'value' => set_value('item-id'),
    'maxlength'	=> 11,

    'size'	=> 11,
);

$itemName = array(
    'name'  => 'item-name',
    'id'    => 'item-name',
    'value' => set_value('item-name'),
    'maxlength'	=> 300,

    'size'	=> 70,
);

$itemPrice = array(
    'name'  => 'item-price',
    'id'    => 'item-price',
    'value' => set_value('item-price'),
    'maxlength'	=> 10,

    'size'	=> 10,
);

$itemQuantity = array(
    'name'  => 'item-quantity',
    'id'    => 'item-quantity',
    'value' => set_value('item-quantity'),
    'maxlength'	=> 8,

    'size'	=> 8,
);

?>
<div id="item-form">
    <?php echo validation_errors(); ?>
    <?php echo form_open(''); ?>
    <?php echo '<table cellspacing="0" cellpadding="1" border="1">'; ?>
    <?php echo '<tr><td>Prekės Id</td><td>Pavadinimas</td><td>Kaina</td><td>Kiekis</td></tr>'; ?>
    <?php foreach($get_items as $row): ?>
    <?php echo '<tr><td>'.$row['itemId'].'</td>'; ?>
    <?php echo '<td>'.$row['itemName'].'</td>'; ?>
    <?php echo '<td>'.$row['itemPrice'].'</td>'; ?>
    <?php echo '<td>'.$row['itemQuantity'].'</td>'; ?>
    <?php echo '</tr>'; ?>
    <?php endforeach; ?>
    <?php echo '</table>'; ?>
    <?php echo form_input($itemId); ?>
    <?php echo form_input($itemName); ?>
    <?php echo form_input($itemPrice); ?>
    <?php echo form_input($itemQuantity); ?>
    <?php echo form_submit('submit', 'Pridėti prekę'); ?>
    <?php echo form_close(); ?>
</div>