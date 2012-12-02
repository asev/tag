<?php

$commentD = array(
    'name'	=> 'comment',
    'id'	=> 'comment',
    'value' => $comment
);

?>
<div id="order-form">
    <?php if(isset($get_items)): ?>
    <?php echo '<table cellspacing="0" cellpadding="1" border="1" width=100%>'; ?>
    <?php echo '<tr><td align=center>Prekės Id</td><td align=center>Pavadinimas</td><td align=center>Kaina</td><td align=center>Kiekis</td><td></td></tr>'; ?>
    <?php foreach($get_items as $row): ?>
        <?php echo '<tr><td align=right>'.$row['itemId'].'</td>'; ?>
        <?php echo '<td align=right>'.$row['itemName'].'</td>'; ?>
        <?php echo '<td align=right>'.$row['itemPrice'].'</td>'; ?>
        <?php echo '<td align=right>'.$row['itemQuantity'].'</td>'; ?>
        <?php echo '<td align=center>'.anchor('item/delete/' . $orderId . '/' . $row['itemId'], 'Ištrinti').'</td>'; ?>
        <?php echo '</tr>'; ?>
        <?php endforeach; ?>
    <?php echo '</table>'; ?>
    <?php endif; ?>
    <?php echo anchor('item/add/' . $orderId, 'Pridėti prekę'); ?>

    <br><br>

<?php
    echo "<p style='margin-bottom: 0;'>Komentaras:</p>";
    echo form_open();
    echo form_textarea($commentD);
    echo form_submit('submit', "Keisti komentarą");
    echo form_close();
?>

    <br><br>

    <?php echo anchor('order/finish/' . $orderId, 'Baigti užsakymą'); ?>

</div>