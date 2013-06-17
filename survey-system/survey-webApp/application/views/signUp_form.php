<!-- Daniel McKay & Ronan Reilly 2012 -->
<h1>Create An Account</h1>
<?php echo form_open('login/create_webUser'); ?>
<fieldset>
    <legend>Personal Information</legend>
    <?php
    echo '<p class="input_label">First Name</p>';
    echo form_input('firstName', set_value('firstName'));
    echo '<p class="input_label">Last Name</p>';
    echo form_input('lastName', set_value('lastName'));
    echo '<p class="input_label">Email</p>';
    echo form_input('email', set_value('email'));
    ?>
</fieldset>

<fieldset>
    <legend>Login Information</legend>
    <?php
    echo '<p class="input_label">Username</p>';
    echo form_input('userName', set_value('userName'));
    echo '<p class="input_label">Password</p>';
    echo form_password('password', set_value('password'));
    echo '<p class="input_label">Password Confirm</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));
    echo form_submit('submit', 'Create Account');
    ?>

    <?php echo validation_errors('<p class="error">', '</p>'); ?>

</fieldset>
<?php echo form_close(); ?>