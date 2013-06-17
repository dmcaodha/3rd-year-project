<!-- Daniel McKay & Ronan Reilly 2012 -->
<div id="create_mobile_user">
    <h1 class="mob_view">Edit Mobile User Password</h1>
    <?php
    echo form_open('webUser_Controllers/manage_mobile_users/edit_mobile_account');
    echo '<p class="input_label">New Password</p>';
    echo form_password('password', set_value('password'));
    echo '<p class="input_label">Confirm New Password</p>';
    echo form_password('passwordConfirm', set_value('passwordConfirm'));
    //echo form_input('passwordConfirm', set_value('passwordConfirm','Confirm Password'));
    //$hidden = array('manager_id' => $this->session->userdata('id'));
    echo form_submit('submit', 'Edit Mobile User Password');
    echo validation_errors('<p class="error">');
    echo form_close();
    echo "<br/>";
    echo anchor('webUser_Controllers/manage_mobile_users/index', 'Manage Mobile Accounts');
    echo "<br/>";
    echo "<br/>";
    echo anchor('webUser_Controllers/webUser_homepage/index', 'Back to Dashboard');
    ?>
</div>

