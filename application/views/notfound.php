<?php //@TODO Gražus 404 puslapis su tekstuku

$messages = array(
    'not-found' => "Užklausa nerasta",
    'denied' => "Užklausa nepasiekima",
    'no-last' => "Nera neatsakytu užklausų",
    'not-defined' => "Nenurodyta užklausa",
    'wrong-page' => "Blogai nurodytas puslapis",
    'no-results' => "Tuščia. Nėra užklausų"
);

echo "<h1>404</h1>";
echo $messages[$message];