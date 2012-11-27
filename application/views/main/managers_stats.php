<?php
function disp($array, $elmement) {
    if (isset($array[$elmement])) {
        echo $array[$elmement];
    } else {
        echo '0';
    }
}
?>
<div id="statistic">
    <table>
        <tr>
            <th>Vadybininkas</th>
            <th>Priimta užklausų</th>
            <th>Sėkmingos užklausos</th>
            <th>Nesėkmingos užklausos</th>
            <th>Šiuo metu turi užklausų</th>
        </tr>
        <?php
            foreach ($managers as $id => $val) :
                ?>
                <tr>
                    <td><?php disp($val, 'name');?></td>
                    <td><?php disp($val, 'm_assign');?></td>
                    <td><?php disp($val, 'm_success');?></td>
                    <td><?php disp($val, 'm_fail');?></td>
                    <td><?php disp($val, 'm_req');?></td>
                </tr>
            <?php endforeach; ?>
    </table>
</div>