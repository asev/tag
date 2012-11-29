<?php
echo "Viso: " . $length;
echo "<br>";
if (!$boss) {
    echo '<style type="text/css"> #requests-list .manager{display: none;}</style>';
}
?>

<table id="requests-list">
    <tr>
        <th class="subject">Tema</th>
        <th class="created">Sukurta</th>
        <th class="author">Autorius</th>
        <th class="email">El. paštas</th>
        <th class="manager">Vadybininkas</th>
        <th></th>
    </tr>
