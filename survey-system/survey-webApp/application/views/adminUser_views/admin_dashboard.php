<!-- Daniel McKay & Ronan Reilly 2012 -->
<div id="admin_form">
    <div class="center_options">
        <h1 class="mob_view">Admin Home Page</h1>
        <!-- Manage web users link -->
        <p><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_web_users', 'Manage Web Users'); ?></p>
        <!-- Manage mobile users link -->
        <p><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_mobile_users', 'Manage Mobile Users'); ?></p>
        <!-- Manage surveys link -->
        <p><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_surveys', 'Manage Surveys'); ?></p>
        <!-- Manage Assignments -->
        <p><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_manage_assignments', 'Manage Assignments'); ?></p>
        <?php echo anchor('login/logout', 'Logout'); ?>
    </div>
</div>