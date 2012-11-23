<?php   //@toGin sutvarkyti sita forma
?>
    <div id="request-form">
        <?php echo validation_errors(); ?>
        <?php echo form_open(''); ?>
        <input type="text" name="full-name" value="name" size="50" />
        <input type="text" name="email" value="email" size="50" />
        <input type="text" name="phone" value="phone" size="50" />
        <input type="text" name="subject" value="subject" size="50" />
        <input type="text" name="request-text" value="text" size="50" />
        <input type="submit" />
        <?php echo form_close(); ?>
    </div>