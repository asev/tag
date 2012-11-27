<?php //@toGin Grazus vaizdavimas

$messages = array(
    'success' => "Sėkmingai pakeista užklausos būsena",
    'already-assigned' => "Užklausa jau priskirta kitam vadybininkui",
    'already-completed' => "Užklausa jau buvo ivykdyta",
    'reassigned' => "Sėkmingai pakeitėte užklausos vadybininką",
    'not-yours' => "Negalima pakeisti vadybininko. Ši užklausa nepriklauso jums.",
    'spammed' => "Pažymojote kaip  šlamštas.",
    'unspammed' => "Pažymėta kaip nebe spam",
    'already-spammed' => "Jau buvo pažymėta, kaip šlamstas",
    'already-unspammed' => "Tai kad ir taip čia nėra šlamštas",
    'spam' => "Čia šlamštas",
    'wrong-state' => "Blogai nurodyta būsena."
);

if (is_null($message) && $spam == '1') {
    $message = 'spam';
}

//rodo zinute
if (!is_null($message)) { echo "<i>" . $messages[$message] . "</i><br>"; }
?>
<div id="request">
<table>
    <tr>
        <td>Tema:</td>
        <td><h2><?php echo $subject; ?><h2></h2></td>
    </tr>
    <tr>
        <td>Informacija apie klientą:</td>
        <td>
            <ul>
                <li><?php echo $fullName; ?></li>
                <li><?php echo $email; ?></li>
                <li><?php echo $phone; ?></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td>Užklausa:</td>
        <td><?php echo $reqText; ?></td>
    </tr>
    <tr>
        <td>Sukurta:</td>
        <td><?php echo $created; ?></td>
    </tr>
</table>
    </div>

