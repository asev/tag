<?php echo anchor('order/generatePDF/' . $get_order['orderId'], 'Parsisiūsti užsakymą PDF formatu'); ?>
<?php echo '<h1 align="center">Užsakymas Nr. ' . $get_order['orderId'] . ' parengtas pagal užklasą Nr. ' . $get_order['requestId'] . '</h1>'; ?>
<?php echo '<p>Kliento duomenys:</p><br/>'; ?>
<?php echo '<i>Vardas: ' . $get_req['fullName'] . ',</i><br/>'; ?>
<?php echo '<i>Elektroninis paštas: ' . $get_req['email'] . ',</i><br/>'; ?>
<?php echo '<i>Telefono numeris: ' . $get_req['phone'] . '.</i><br/><br/>'; ?>
<?php echo '<h1 align="center">Siūlomos prekės:</h1>'; ?>
<?php echo '<table cellspacing="0" cellpadding="1" border="1" width=100%>'; ?>
<?php echo '<tr><td align=center>Prekės Id</td><td align=center>Pavadinimas</td><td align=center>Kaina</td><td align=center>Kiekis</td></tr>'; ?>
<?php foreach($get_items as $row): ?>
<?php echo '<tr><td align=right>'.$row['itemId'].'</td>'; ?>
<?php echo '<td align=right>'.$row['itemName'].'</td>'; ?>
<?php echo '<td align=right>'.$row['itemPrice'].'</td>'; ?>
<?php echo '<td align=right>'.$row['itemQuantity'].'</td>'; ?>
<?php echo '</tr>'; ?>
<?php endforeach; ?>
<?php echo '</table><br/>'; ?>
<?php echo '<h1 align="center">Papildoma informacija:</h1>'; ?>
<?php echo '<table cellspacing="0" cellpadding="1" border="1" width=100%>'; ?>
<?php echo '<tr><td>' . $get_order['comment'] . ' <br/></td></tr></table><br/>'; ?>
<?php echo anchor('order/generatePDF/' . $get_order['orderId'], 'Parsisiūsti užsakymą PDF formatu'); ?>