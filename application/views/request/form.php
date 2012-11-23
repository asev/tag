<?php   //@toGin sutvarkyti sita forma
$fullName = array(
    'name'	=> 'full-name',
    'id'	=> 'full-name',
    'value' => set_value('full-name'),
    'maxlength'	=> 100,

    'size'	=> 30,
);

$email = array(
    'name'	=> 'email',
    'id'	=> 'email',
    'value' => set_value('email'),
    'maxlength'	=> 100,

    'size'	=> 30,
);

$phoneNumber = array(
    'name'	=> 'phoneNumber',
    'id'	=> 'phoneNumber',
    'value' => set_value('phone number'),
    'maxlength'	=> 50,

    'size'	=> 30,
);

$subject = array(
    'name'	=> 'subject',
    'id'	=> 'subject',
    'value' => set_value('subject'),
    'maxlength'	=> 500,

    'size'	=> 30,
);

$request = array(
    'name'	=> 'request-text',
    'id'	=> 'request-text',
    'value' => set_value('request'),
    'maxlength'	=> 2000,

    'size'	=> 100,
);
?>
    <div id="request-form">
        <?php echo validation_errors(); ?>
        <?php echo form_open(''); ?>
        <p class="flabel"><?php echo form_label('Vardas', $fullName['id']); ?></p>
        <?php echo form_input($fullName); ?>
        <p class="flabel"><?php echo form_label('El. pastas', $email['id']); ?></p>
        <?php echo form_input($email); ?>
        <p class="flabel"><?php echo form_label('Telefono numeris', $phoneNumber['id']); ?></p>
        <?php echo form_input($phoneNumber); ?>
        <p class="flabel"><?php echo form_label('Tema', $subject['id']); ?></p>
        <?php echo form_input($subject); ?>
        <p class="flabel"><?php echo form_label('Uzklausa', $request['id']); ?></p>
        <?php echo form_textarea($request);?>
        <br>
        <?php echo form_submit('submit','pateikti');?>
        <?php echo form_close(); ?>
    </div>