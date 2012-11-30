<?php

$comment = array(
    'name'  => 'order-comment',
    'id'    => 'order-comment',
    'value' => set_value('order-comment'),
    'maxlength'	=> 2000,

    'size'	=> 200,
);

?>
<div id="order-form">
    <?php if(isset($get_items)): ?>
    <?php echo '<table border="1">'; ?>
    <?php echo '<tr><td>Prekės Id</td><td>Pavadinimas</td><td>Kaina</td><td>Kiekis</td><td></td></td></tr>'; ?>
    <?php foreach($get_items as $row): ?>
        <?php echo '<tr><td>'.$row['itemId'].'</td>'; ?>
        <?php echo '<td>'.$row['itemName'].'</td>'; ?>
        <?php echo '<td>'.$row['itemPrice'].'</td>'; ?>
        <?php echo '<td>'.$row['itemQuantity'].'</td>'; ?>
        <?php echo '<td>'.anchor('item/delete/' . $orderId . '/' . $row['itemId'], 'Ištrinti').'</td>'; ?>
        <?php echo '</tr>'; ?>
        <?php endforeach; ?>
    <?php echo '</table>'; ?>
    <?php endif; ?>
    <?php echo anchor('item/add/' . $orderId, 'Pridėti prekę'); ?>
</div>