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
<div id="dates">
<ul>
<li class="border-boss"><?php $c = ($term == 3) ? $current : $notc; echo anchor('main/boss/1/3', "Šiandien", $c); ?></li>
    <li class="border-boss"><?php $c = ($term == 2) ? $current : $notc; echo anchor('main/boss/1/2', "Šį mėnesį", $c); ?></li>
    <li class="border-boss"><?php $c = ($term == 1) ? $current : $notc; echo anchor('main/boss/1/1', "Šiais metais", $c); ?></li>
    <li class="border-non"><?php $c = ($term == 0) ? $current : $notc; echo anchor('main/boss/1/0', "Visą laiką", $c); ?></li>
    </ul>
</div>
<div id="statistic">

    <table id="one-column-emphasis" class="tablesorter">
        <thead>
        <tr >
            <th class="header">Vadybininkas</th>
            <th class="header">Priimta užklausų</th>
            <th class="header">Sėkmingos užklausos</th>
            <th class="header">Nesėkmingos užklausos</th>
            <th class="header">Šiuo metu turi užklausų</th>
            <th class="header">Uždirbtos pajamos</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($managers as $id => $val) :
                ?>
                <tr class="odd">
                    <td class="oce-first"><?php echo check_element($val, 'name');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_assign');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_success');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_fail');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_req');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_income');?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">$(document).ready(function(){$("#one-column-emphasis").tablesorter( {sortList: [[5,1], [1,1]]} );});</script>
