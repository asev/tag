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
    <div class="subject-date">
    <h2><?php echo $subject; ?></h2>
    <p><?php echo $created; ?></p>
    </div>
    <div class="client-information">
        <p class="bold"><?php echo $fullName; ?></p>
        <p class="pcenter italic"><?php echo $email; ?></p>
        <p class="pright italic"><?php echo $phone; ?></p>
        <div class="clear"></div>
    </div>
    <div class="request-text">
    <p><?php echo $reqText; ?></p>
    </div>
</div>

