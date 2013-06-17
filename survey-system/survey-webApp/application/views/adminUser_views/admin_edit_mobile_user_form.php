<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="adminUser_manage_mobile">
    <p class="help_admin33 marg"><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users', 'Manage All Mobile Accounts'); ?></p>
    <p class="back_to_dash33"><?php echo anchor('adminUser_Controllers/adminUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout33"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="create_mobile_user">
    <h1 class="mob_view">Edit Mobile User Password</h1>
    <?php
    echo form_open('adminUser_Controllers/adminUser_homepage/edit_mobile_account');
    echo '<p class="input_label">New Password</p>';
    echo form_password('password', set_value('password'));
    echo '<p class="input_label">Confirm New Password</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));
    //echo form_input('passwordConfirm', set_value('passwordConfirm','Confirm Password'));
    //$hidden = array('manager_id' => $this->session->userdata('id'));
    echo form_submit('submit', 'Edit Mobile User Password');
    echo validation_errors('<p class="error">');
    echo form_close();
    ?>
</div>

