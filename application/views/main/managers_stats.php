<?php
function check_element($array, $elmement) {
    if (isset($array[$elmement])) {
        return $array[$elmement];
    } else {
        return '0';
    }
}
//@toGin Lentelę gražiai atvaizduoti pagal http://tablesorter.com/themes/blue/blue.zip
//@toGin Padaryti gražų datų pasirinkimo vaizdavimą
?>
<div class="dates"><?php
    echo anchor('main/boss/1/3', "Šiandien");
    echo anchor('main/boss/1/2', "Šį mėnesį");
    echo anchor('main/boss/1/1', "Šiais metais");
    echo anchor('main/boss/1/0', "Visą laiką");
    ?>
</div>
<div id="statistic">

    <table id="statTable" class="tablesorter">
        <thead>
        <tr>
            <th>Vadybininkas</th>
            <th>Priimta užklausų</th>
            <th>Sėkmingos užklausos</th>
            <th>Nesėkmingos užklausos</th>
            <th>Šiuo metu turi užklausų</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($managers as $id => $val) :
                ?>
                <tr>
                    <td><?php echo check_element($val, 'name');?></td>
                    <td><?php echo check_element($val, 'm_assign');?></td>
                    <td><?php echo check_element($val, 'm_success');?></td>
                    <td><?php echo check_element($val, 'm_fail');?></td>
                    <td><?php echo check_element($val, 'm_req');?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">$(document).ready(function(){$("#statTable").tablesorter();});</script>