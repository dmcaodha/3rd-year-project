<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="adminUser_manage_mobile_b">
    <p class="help_admin33 marg"><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users', 'Manage All Mobile Accounts'); ?></p>
    <p class="back_to_dash33"><?php echo anchor('adminUser_Controllers/adminUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout33"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="create_mobile_user">
    <h1 class="mob_view">Admin Create Mobile User Account</h1>
    <?php
    echo form_open('adminUser_Controllers/adminUser_homepage/create_mobile_account');
    echo '<p class="input_label">Username</p>';
    echo form_input('userName', set_value('userName'));
    echo '<p class="input_label">Password</p>';
    echo form_password('password', set_value('password'));
    echo '<p class="input_label">Confirm Password</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));
    echo form_submit('submit', 'Create Mobile User');
    echo "<br/>";
    echo validation_errors('<p class="error">');
    echo form_close();
    ?>
</div>