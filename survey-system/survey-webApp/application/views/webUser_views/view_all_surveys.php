<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="toolbar2">
    <p class="create"><?php echo anchor('webUser_controllers/survey_controller/new_survey', 'Create Survey'); ?></p>
    <p class="back_link"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="survey_list">
    <h1><?php echo $this->session->userdata('username'); ?>'s Surveys</h1>
    <?php
    if (!empty($rows)) {
        echo '<ul>';
        foreach ($rows as $row) {
            ?>
            <li>
                <?php echo $row->title;
                echo anchor("webUser_Controllers/survey_controller/view_survey_details/$row->id", 'View Survey Details', 'class="rightlink"');
                ?>
            </li>
            <?php
        }
        echo '</ul>';
    } else {
        echo '<h1 class="error_head">You dont have any surveys yet!</h1>';
    }
    ?>
</div>
