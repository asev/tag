<div id="main-manager">
    <?php
    echo "Vadovas: " . $username . "<br>";
    echo anchor('main/boss/', "vadybininku statistika");
    echo anchor('main/boss/2', "Užklausų statistika");
    echo anchor('main/boss/3', "Dabartinė charakteristika");
    ?>
</div>
<div id="search">
    <?php echo form_open('');
    echo form_input('search', set_value('search'));
    echo form_submit('submit', "Ieškoti");
    echo form_close(); ?>
</div>