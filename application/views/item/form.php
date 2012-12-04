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

    'size'	=> 55,
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
    'value' => set_value('item-quantity','1'),
    'maxlength'	=> 8,

    'size'	=> 8,
);

?>
<div id="item-form" class="order-table">
    <?php echo validation_errors(); ?>
    <table>
        <tr>
    <td>Pavadinimas</td>
            <td>Kaina</td>
            <td>Kiekis</td>
            </tr>
    <?php foreach($get_items as $row): ?>
    <tr>
    <td><?php echo $row['itemName']; ?></td>
    <td><?php echo $row['itemPrice']; ?></td>
    <td><?php echo $row['itemQuantity']; ?></td>
    </tr>
    <?php endforeach; ?>
    </table>
    <?php echo form_open(''); ?>
    <?php echo form_input($itemName); ?>
    <?php echo form_input($itemPrice); ?>
    <?php echo form_input($itemQuantity); ?>
    <?php echo form_submit('submit', 'Pridėti prekę'); ?>
    <?php echo form_close(); ?>
</div>