<?php $c = array('class' => 'current');
?>
<div class="sub-menu">
    <ul>
        <li><?php $isC = array(); if ($stats==1 || $stats == null) $isC = $c; echo anchor('main/boss/', "Vadybininkų statistika", $isC); ?></li>
        <li><?php $isC = array(); if ($stats==2) $isC = $c; echo anchor('main/boss/2', "Užklausų statistika", $isC); ?></li>
        <li><?php $isC = array(); if ($stats==3) $isC = $c; echo anchor('main/boss/3', "Dabartinė charakteristika", $isC); ?></li>
        <li><?php $isC = array(); if ($stats==4) $isC = $c; echo anchor('auth/register', "Vadybininkų registracija", $isC); ?></li>
    </ul>
</div>