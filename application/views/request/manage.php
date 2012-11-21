<?php

    $managers = array(
        'small'  => 'Small Shirt',
        'med'    => 'Medium Shirt',
        'large'   => 'Large Shirt',
        'xlarge' => 'Extra Large Shirt',
    );


switch($state) {

    case "0" :
        echo anchor('req/assign/'. $requestId ,"Priskirti man!");
        echo anchor('req/spam/'. $requestId ,"Pažymėti kaip spam");
        break;
    case "1" :
        if ($manager == $mId) {
            echo anchor('order/add/'. $requestId ,"Sukurti užsakymą"); // Dar nežinau ar tokia nuroda bus
            echo form_open('req/reassign/'. $requestId);
            echo form_dropdown('nextManager', $managers);
            echo form_submit('submit', 'Keisti vadybininką');
            echo form_close();
            echo anchor('req/reassign/'. $requestId ,"Perleisti kitam vadybinkui"); // @TODO Čia reiks padaryti input, kur bus galima išskirinkti iš kitų vadybininkų
        } else {
            echo "Su klientu bendrauja " . $username;
        }
        break;
    case "2" :
        echo "Užklausa atlikta."; //@TODO Nurodyti kuris vadybinikas bendravo
        break;
}

