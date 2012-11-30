<?php
?>
<h3>Šiuo metu turimos užklausos: <?php echo anchor('reqs/current', $current . ' &raquo;');?></h3>

    <table>
        <tr>
            <th></th>
            <th>Priimta užklausų</th>
            <th>Sėkmingai pasibaigusios</th>
            <th>Nesėkmingai pasibaigusios</th>
        </tr>
        <?php
    foreach ($stats as $stat) : ?>
        <tr>
            <th><?php echo $stat['title']; ?></th>
            <td><?php echo $stat['assign']; ?></td>
            <td><?php echo $stat['success']; ?></td>
            <td><?php echo $stat['fail']; ?></td>
        </tr>
            <?php endforeach; ?>
    </table>