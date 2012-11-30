<div class="dates"><?php //@toGin Padaryti gražų datų pasirinkimo vaizdavimą. Sutvarkyti lentelę (taip pat ir current_stats)
    echo anchor('main/boss/2/3', "Šiandien");
    echo anchor('main/boss/2/2', "Šį mėnesį");
    echo anchor('main/boss/2/1', "Šiais metais");
    echo anchor('main/boss/2/0', "Visą laiką");
    ?>
</div>
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