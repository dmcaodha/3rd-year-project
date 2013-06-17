<!-- Daniel McKay & Ronan Reilly 2012 -->
<div id="login_form">
    <h1>Please Login</h1>
    <?php
    echo form_open('login/validate_credentials');
    echo '<p class="input_label light">Username</p>';
    echo form_input('username', set_value('username'));
    echo '<p class="input_label light">Password</p>';
    echo form_password('password', set_value('password'));
    echo form_submit('submit', 'Login');
    echo anchor('login/signup', 'Create Account');
    echo form_close();
    ?>
    <?php echo validation_errors('<p class="error">', '</p>'); ?>
</div>