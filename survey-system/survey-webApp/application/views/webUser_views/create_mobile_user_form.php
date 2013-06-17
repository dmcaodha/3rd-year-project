<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbara">
    <p class="manamob_linka"><?php echo anchor('webUser_Controllers/manage_mobile_users/index', 'Manage Mobile Accounts'); ?></p>
    <p class="back_linka"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_linka"><?php echo anchor('login/logout', 'Logout'); ?></p>

</div>
<div id="create_mobile_user">
    <h1 class="mob_view">Create Mobile User Account</h1>
    <?php
    echo form_open('webUser_Controllers/manage_mobile_users/create_mobile_account');
    echo '<p class="input_label">Username</p>';
    echo form_input('userName', set_value('userName'));
    echo '<p class="input_label">Password</p>';
    echo form_password('password', set_value('password'));
    echo '<p class="input_label">Confirm Password</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));
    //echo form_input('passwordConfirm', set_value('passwordConfirm','Confirm Password'));
    //$hidden = array('manager_id' => $this->session->userdata('id'));
    echo form_submit('submit', 'Create Mobile User');
    echo validation_errors('<p class="error">');
    echo form_close();
    ?>
</div>