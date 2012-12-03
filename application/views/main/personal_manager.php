<?php
?>
<h3>Šiuo metu turimos užklausos: <?php echo anchor('reqs/current', $current . ' &raquo;');?></h3>

    <div id="personal-manager">
    <table>
        <tr class="bold">
            <th></th>
            <th>Priimtos užklausos</th>
            <th>Sėkmingai pasibaigusios</th>
            <th>Nesėkmingai pasibaigusios</th>
        </tr>
        <?php
    foreach ($stats as $stat) : ?>
        <tr class="status">
            <th><?php echo $stat['title']; ?></th>
            <td class="border-none"><?php echo $stat['assign']; ?></td>
            <td class="border-none"><?php echo $stat['success']; ?></td>
            <td class="border-none"><?php echo $stat['fail']; ?></td>
        </tr>
            <?php endforeach; ?>
    </table>
        </div>
