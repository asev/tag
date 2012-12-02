<?php
$current = array('class' => 'current');
$notc = array();
        ?>
<div id="dates">
    <ul>
        <li class="border-boss"><?php $c = ($term == 3) ? $current : $notc; echo anchor('main/boss/2/3', "Šiandien", $c); ?></li>
        <li class="border-boss"><?php $c = ($term == 2) ? $current : $notc; echo anchor('main/boss/2/2', "Šį mėnesį", $c); ?></li>
        <li class="border-boss"><?php $c = ($term == 1) ? $current : $notc; echo anchor('main/boss/2/1', "Šiais metais", $c); ?></li>
        <li class="border-non"><?php $c = ($term == 0) ? $current : $notc; echo anchor('main/boss/2/0', "Visą laiką", $c); ?></li>
    </ul>
</div>
    <div id="req-table">
<table>
    <tr>
        <th class="padding">Pateikta užklausų</th>
        <td class="padding-td"><?php echo $reqDate['r_new']; ?></td>
    </tr>
    <tr>
        <th class="padding">Tarp jų šlamšto</th>
        <td class="padding-td"><?php echo ($reqDate['r_new'] != 0) ? $reqDate['r_spam'] . ' (' . round($reqDate['r_spam']/$reqDate['r_new']*100, 2) . '%)' : '0 (0%)'; ?></td>
    </tr>
</table>
    </div>
        <div id="req-table2">
    <table>
        <tr>
            <th class="padding">Įvykdyta užklausų</th>
            <td class="padding-td"><?php echo $reqDate['r_success'] + $reqDate['r_fail']; ?></td>
        </tr>
        <tr>
            <th class="padding">Sėkmingai</th>
            <td class="padding-td"><?php echo $reqDate['r_success']; ?></td>
        </tr>
        <tr>
            <th class="padding">Nesėkmingai</th>
            <td class="padding-td"><?php echo $reqDate['r_fail']; ?></td>
        </tr>
    </table>
        </div>
