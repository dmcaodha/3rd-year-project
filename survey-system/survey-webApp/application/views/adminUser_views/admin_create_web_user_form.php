<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="adminUser_manage_mobile_a">
    <p class="help_admin33 marg"><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_web_users', 'Manage All Web Accounts'); ?></p>
    <p class="back_to_dash33"><?php echo anchor('adminUser_Controllers/adminUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout33"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="admin_create_web_user">
    <h1>Admin Create User Account</h1>

    <p class="admin_form_p light">Enter New Account Information</p>
    <?php
    echo form_open('adminUser_Controllers/adminUser_homepage/create_new_web_user');
    echo '<p class="input_label light">First Name</p>';
    echo form_input('firstName', set_value('firstName'));
    echo '<p class="input_label light">Last Name</p>';
    echo form_input('lastName', set_value('lastName'));
    echo '<p class="input_label light">Email</p>';
    echo form_input('email', set_value('email'));
    echo '<p class="input_label light">Username</p>';
    echo form_input('userName', set_value('userName'));
    echo '<p class="input_label light">Password</p>';
    echo form_password('password');
    echo '<p class="input_label light">Confirm Password</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));

    echo form_submit('submit', 'Create Account');
    echo form_close();
    echo "<br/>";
    echo validation_errors('<p class="error">');
    ?>
</div>
