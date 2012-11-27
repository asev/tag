<?php //@toGin Grazus vaizdavimas

$messages = array(
    'success' => "Sėkmingai pakeista užklausos būsena",
    'already-assigned' => "Užklausa jau priskirta kitam vadybininkui",
    'already-completed' => "Užklausa jau buvo ivykdyta",
    'reassigned' => "Sėkmingai pakeitėte užklausos vadybininką",
    'not-yours' => "Negalima pakeisti vadybininko. Ši užklausa nepriklauso jums.",
    'spammed' => "Pazymojote kaip  šlamštas.",
    'unspammed' => "Pažymėta kaip nebe spam",
    'already-spammed' => "Jau buvo pazymeta, kad slamstas",
    'already-unspammed' => "Tai kad ir taip cia nera slamstas",
    'spam' => "Čia šlamštas",
    'wrong-state' => "Blogai nurodyta busena."
);

if (is_null($message) && $spam == '1') {
    $message = 'spam';
}

echo "<h1>Uzklausa</h1>";
//rodo zinute
if (!is_null($message)) { echo "<i>" . $messages[$message] . "</i><br>"; }
echo "<br>";
echo "ID: " . $requestId;
echo "<br>";
echo "name: " .$fullName;
echo "<br>";
echo "email: " . $email;
echo "<br>";
echo "phone: " . $phone;
echo "<br>";
echo "subject: " . $subject;
echo "<br>";
echo "uzklausa: " . $reqText;
echo "<br>";
echo "sukurta: " . $created;
