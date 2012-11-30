<?php
function check_element($array, $elmement) {
    if (isset($array[$elmement])) {
        return $array[$elmement];
    } else {
        return '0';
    }
}
?>
<div id="dates">
<ul>
<li class="border-boss"><?php echo anchor('main/boss/1/3', "Šiandien"); ?></li>
    <li class="border-boss"><?php echo anchor('main/boss/1/2', "Šį mėnesį"); ?></li>
    <li class="border-boss"><?php echo anchor('main/boss/1/1', "Šiais metais"); ?></li>
    <li class="border-non"><?php echo anchor('main/boss/1/0', "Visą laiką"); ?></li>
    </ul>
</div>
<div id="statistic">

    <table id="one-column-emphasis" class="tablesorter">
        <thead>
        <tr >
            <th class="headerSortUp headerSortDown header">Vadybininkas</th>
            <th class="headerSortUp headerSortDown header">Priimta užklausų</th>
            <th class="headerSortUp headerSortDown header">Sėkmingos užklausos</th>
            <th class="headerSortUp headerSortDown header">Nesėkmingos užklausos</th>
            <th class="headerSortUp headerSortDown header">Šiuo metu turi užklausų</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($managers as $id => $val) :
                ?>
                <tr class="odd header">
                    <td class="oce-first"><?php echo check_element($val, 'name');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_assign');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_success');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_fail');?></td>
                    <td class="oce-first"><?php echo check_element($val, 'm_req');?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.tablesorter.min.js"></script>
<script type="text/javascript">$(document).ready(function(){$("#one-column-emphasis").tablesorter();});</script>