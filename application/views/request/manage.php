<?php //@toGin Vaizdavimas

$managers = array(
    '' => '',
    '1' => 'Jonas P',
    '2' => 'Petras J'
);

$commentD = array(
    'name'	=> 'comment',
    'id'	=> 'comment',
    'value' => $comment
);


?>
<div id="manage-request"><h3>Manage</h3><br>
    <?php
switch ($state) {

    case "0" :
        echo anchor('req/assign/' . $requestId, "Priskirti man!");
        echo "<br>";
        if ($spam == 0) {
            echo anchor('req/spam/' . $requestId, "Pažymėti kaip spam");
        } else {
            echo anchor('req/unspam/' . $requestId, "Pažymėti kaip ne spam");
        }
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
        echo "Užklausa atlikta. Bendravo " . $username;
        break;
}

    echo "<p style='margin-bottom: 0;'>Komentaras:</p>";
    echo form_open();
    echo form_textarea($commentD);
    echo form_submit('submit', "Keisti komentarą");
    echo form_close();

?>
    </div>
