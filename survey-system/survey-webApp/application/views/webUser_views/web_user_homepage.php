<!-- Daniel McKay & Ronan Reilly 2012 -->
<div id="admin_form">
    <h1 class="mob_view">User Home</h1>
    <div class="center_options">
        <!-- Web User Home Page Links -->
        <p><?php echo anchor('webUser_Controllers/survey_controller/new_survey', 'Create a Survey'); ?></p>
        <p><?php echo anchor('webUser_Controllers/survey_controller/all_user_surveys', 'Manage Your Surveys'); ?></p>
        <p><?php echo anchor('webUser_Controllers/manage_mobile_users/index', 'Manage Mobile Users'); ?></p>
        <?php echo anchor('login/logout', 'Logout'); ?>

    </div>
</div>
