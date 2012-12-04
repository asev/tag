<?php

$commentD = array(
    'name'	=> 'comment',
    'id'	=> 'comment',
    'value' => $comment
);

?>
<div class="manage-request order-table">
    <?php if(isset($get_items)): ?>
    <table>
        <tr>
        <td>Pavadinimas</td>
        <td>Kaina</td>
        <td>Kiekis</td>
            <td></td>
    </tr>
    <?php foreach($get_items as $row): ?>
        <tr>
        <td><?php echo $row['itemName']; ?></td>
        <td><?php echo $row['itemPrice']; ?></td>
        <td><?php echo $row['itemQuantity']; ?></td>
        <td><?php echo anchor('item/delete/' . $orderId . '/' . $row['itemId'], 'Ištrinti'); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    <p class="order"><?php echo anchor('item/add/' . $orderId, 'Pridėti prekę'); ?></p>

    <br><br>

<?php
    echo form_label('Komentaras:');
    echo form_open();
    echo form_textarea($commentD);
    echo form_submit('submit', "Keisti komentarą");
    echo form_close();
?>

    <br><br>

    <?php echo anchor('order/finish/' . $orderId, 'Baigti užsakymą'); ?>

</div>