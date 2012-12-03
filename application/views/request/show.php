<?php //@toGin Grazus vaizdavimas

$messages = array(
    'success' => "Sėkmingai pakeista užklausos būsena",
    'already-assigned' => "Užklausa priskirta kitam vadybininkui",
    'already-completed' => "Užklausa įvykdyta",
    'reassigned' => "Sėkmingai pakeitas užklausos vadybininkas",
    'not-yours' => "Negalima pakeisti vadybininko. Ši užklausa nepriklauso jums.",
    'spammed' => "Pažymėta kaip  šlamštas",
    'unspammed' => "Pažymėta ne šlamštas",
    'already-spammed' => "Jau buvo pažymėta, kaip šlamstas",
    'already-unspammed' => "Jau pažymėta kaip šlamštas",
    'spam' => "Šlamštas",
    'wrong-state' => "Blogai nurodyta būsena"
);

if (is_null($message) && $spam == '1') {
    $message = 'spam';
}

//rodo zinute
if (!is_null($message)) { echo '<div class="not-found">' . $messages[$message] . '</div>'; }
?>
<div id="request">
    <div class="subject-date">
    <h2><?php echo $subject; ?></h2>
    <p><?php echo $created; ?></p>
    </div>
    <div class="client-information">
        <div class="col bold"><?php echo $fullName; ?></div>
        <div class="col align-center italic">
            <span><?php echo $email; ?></span><?php echo form_open('reqs/client'); echo form_hidden('email',$email); echo form_submit('submit-email', '( ' .$history . ' )', 'title="Rodyti visas kliento užklausas"'); echo form_close();// echo anchor('', $history, 'title="Rodyti visas kliento užklauas"'); ?></div>
        <div class="col align-right italic"><?php echo $phone; ?></div>

    </div>
    <div class="clear"></div>
    <div class="request-text">
    <p><?php echo $reqText; ?></p>
    </div>
</div>

