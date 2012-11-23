<?php //@toGin Grazus vaizdavimas

$messages = array(
    'success' => "Užklausa priskirta jums",
    'already-assigned' => "Užklausa jau priskirta kitam vadybininkui",
    'reassigned' => "Sėkmingai pakeitėte užklausos vadybininką",
    'not-yours' => "Negalima pakeisti vadybininko. Ši užklausa nepriklauso jums."
);

echo "<h1>Uzklausa</h1>";
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
