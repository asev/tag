<?php
function check_element($array, $elmement) {
    if (isset($array[$elmement])) {
        return $array[$elmement];
    } else {
        return '0';
    }
}

$current = array('class' => 'current');
$notc = array();
?>
<div class="sub-menu">
<ul>
<li><?php $c = ($term == 3) ? $current : $notc; echo anchor('main/boss/1/3', "Šiandien", $c); ?></li>
    <li><?php $c = ($term == 2) ? $current : $notc; echo anchor('main/boss/1/2', "Šį mėnesį", $c); ?></li>
    <li><?php $c = ($term == 1) ? $current : $notc; echo anchor('main/boss/1/1', "Šiais metais", $c); ?></li>
    <li><?php $c = ($term == 0) ? $current : $notc; echo anchor('main/boss/1/0', "Visą laiką", $c); ?></li>
    </ul>
</div>
<div id="statistic">

    <table id="one-column-emphasis" class="tablesorter">
        <thead>
        <tr >
            <th>Vadybininkas</th>
            <th>Priimta užklausų</th>
            <th>Sėkmingos užklausos</th>
            <th>Nesėkmingos užklausos</th>
            <th>Šiuo metu turi užklausų</th>
            <th>Uždirbtos pajamos</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($managers as $id => $val) :
                ?>
                <tr class="odd header">
                    <td><?php echo check_element($val, 'name');?></td>
                    <td><?php echo check_element($val, 'm_assign');?></td>
                    <td><?php echo check_element($val, 'm_success');?></td>
                    <td><?php echo check_element($val, 'm_fail');?></td>
                    <td><?php echo check_element($val, 'm_req');?></td>
                    <td><?php echo check_element($val, 'm_income');?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">$(document).ready(function(){$("#one-column-emphasis").tablesorter( {sortList: [[5,1], [1,1]]} );});</script>
