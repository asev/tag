<?php

$commentD = array(
    'name'	=> 'comment',
    'id'	=> 'comment',
    'value' => $comment
);


?>
<div class="manage-request">
    <?php
switch ($state) {

    case "0" :
        ?>
        <ul>
        <?php
        echo '<li>' . anchor('req/assign/' . $requestId, "Priskirti man!") . '</li>';
        if ($spam == 0) {
            echo '<li>'. anchor('req/spam/' . $requestId, "Pažymėti kaip spam").'</li>';
        } else {
            echo '<li>'.anchor('req/unspam/' . $requestId, "Pažymėti kaip ne spam").'</li>';
        }?>
        </ul>
        <?php
        break;
    case "1" :
        if ($manager == $mId) {
            ?>
            <ul>
            <?php
            echo  '<li>'.anchor('order/add/' . $requestId, "Užsakymas").'</li>';
            echo '<li>'.anchor('req/finish/' . $requestId . '/2', "Pardavimas įvykdytas").'</li>';
            echo '<li>'.anchor('req/finish/' . $requestId .'/3', "Pardavimas neįvyko").'</li>';
                ?>
            </ul>
            <?php
            echo form_open('req/reassign/' . $requestId);
            echo form_dropdown('nextManager', $managers);
            echo form_submit('submit', 'Keisti vadybininką');
            echo form_close();
        } else {
            echo "<p>Su klientu bendrauja" . $username . '</p>';
        }
        break;
    case "2" :
        echo "<p>Užklausa atlikta. Pardavimas įvyko. Bendravo " . $username . '</p>';
        echo  '<p class="order">'.anchor('order/add/' . $requestId, "Užsakymas").'</p>';
        break;
    case "3" :
        echo "<p>Užklausa atlikta. Pardavimas nepavyko. Bendravo " . $username . '</p>';
        break;
}
    echo form_label('Komentaras:');
    echo form_open();
    echo form_textarea($commentD);
    echo form_submit('submit', "Keisti komentarą");
    echo form_close();

?>
    </div>
