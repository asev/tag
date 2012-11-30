<!--Padaryti gražų datų pasirinkimo vaizdavimą. Sutvarkyti lentelę (taip pat ir current_stats)-->
<div id="dates" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html"
     xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">
    <ul>
    <li class="border-boss"><?php echo anchor('main/boss/2/3', "Šiandien"); ?></li>
    <li class="border-boss"><?php echo anchor('main/boss/2/2', "Šį mėnesį"); ?></li>
    <li class="border-boss"><?php echo anchor('main/boss/2/1', "Šiais metais"); ?></li>
    <li class="border-non"><?php echo anchor('main/boss/2/0', "Visą laiką"); ?></li>
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
