<?php //@toGin Vaizdavimas

$managers = array(
    '' => '',
    '1' => 'Jonas P',
    '2' => 'Petras J'
);


?>
<div id="manage-request"><h3>Manage</h3><br>
    <?php
switch ($state) {

    case "0" :
        echo anchor('req/assign/' . $requestId, "Priskirti man!");
        echo "<br>";
        echo anchor('req/spam/' . $requestId, "Pažymėti kaip spam");
        break;
    case "1" :
        if ($manager == $mId) {
            echo anchor('order/add/' . $requestId, "Sukurti užsakymą"); // Dar nežinau ar tokia nuoroda bus
            echo form_open('req/reassign/' . $requestId);
            echo form_dropdown('nextManager', $managers);
            echo form_submit('submit', 'Keisti vadybininką');
            echo form_close();
        } else {
            echo "Su klientu bendrauja " . $username;
        }
        break;
    case "2" :
        echo "Užklausa atlikta. Bendravo " . $username; //@TODO Nurodyti kuris vadybinikas bendravo
        break;
}

?>
    </div>
