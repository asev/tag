<?php

$messages = array(
    'not-found' => "Ši užklausa neegzistuoja.",
    'denied' => "Užklausa šiuo metu nepasiekiama. Tikriausiai prieš ją yra kitų neatsakytų užklausų.<br>Pabandykite peržiūrėti " . anchor('req/show/last', 'naujausią užklausą') . ".",
    'no-last' => "Nera laukiančių užklausų.",
    'not-defined' => "Atsiprašome. Nenurodėte užklausos arba įvyko klaida.",
    'no-results' => "Neradome užklausų pagal jūsų nurodytus kriterijus.",
    'no-client' => "Nenurodytas kliento el. pašto adresas pagal kurį norite ieškoti užklausų.",
    '404' => 'Puslapis kurį bandote pasiekti neegzisutoja.'
);
?>
<div class="not-found">
<?php echo $messages[$message]; ?>
</div>