<?php
$current = array('class' => 'current');
$notc = array();
        ?>
<div class="sub-menu">
    <ul>
        <li><?php $c = ($term == 3) ? $current : $notc; echo anchor('main/boss/2/3', "Šiandien", $c); ?></li>
        <li><?php $c = ($term == 2) ? $current : $notc; echo anchor('main/boss/2/2', "Šį mėnesį", $c); ?></li>
        <li><?php $c = ($term == 1) ? $current : $notc; echo anchor('main/boss/2/1', "Šiais metais", $c); ?></li>
        <li><?php $c = ($term == 0) ? $current : $notc; echo anchor('main/boss/2/0', "Visą laiką", $c); ?></li>
    </ul>
</div>
    <div class="tables">
<table>
    <tr>
        <th>Pateikta užklausų</th>
        <td><?php echo $reqDate['r_new']; ?></td>
    </tr>
    <tr>
        <th>Tarp jų šlamšto</th>
        <td><?php echo ($reqDate['r_new'] != 0) ? $reqDate['r_spam'] . ' (' . round($reqDate['r_spam']/$reqDate['r_new']*100, 2) . '%)' : '0 (0%)'; ?></td>
    </tr>
</table>
    </div>
        <div class="tables">
    <table>
        <tr>
            <th>Įvykdyta užklausų</th>
            <td><?php echo $reqDate['r_success'] + $reqDate['r_fail']; ?></td>
        </tr>
        <tr>
            <th>Sėkmingai</th>
            <td><?php echo $reqDate['r_success']; ?></td>
        </tr>
        <tr>
            <th>Nesėkmingai</th>
            <td><?php echo $reqDate['r_fail']; ?></td>
        </tr>
    </table>
        </div>
