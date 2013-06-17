<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar4">
    <p class="view_surveys4"><?php echo anchor('webUser_Controllers/survey_controller/all_user_surveys', 'Back to Surveys'); ?></p>
    <p class="back_link4"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link4"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div>
    <h1>View Survey</h1>
    <div id="survey_heading">
        <h2>Survey Details</h2>
        <h5>Title: <?php echo $survey->title; ?></h5>
        <h5>Topic: <?php echo $survey->topic; ?></h5>
        <h5>Date Created: <?php echo $survey->dateCreated; ?></h5>
    </div>
    <div class="survey_box">
        <p><?php echo anchor("webUser_Controllers/assignment_controller/load_assign_survey_page/$survey->id", 'Assign Survey', 'class=""'); ?></p>
        <p><?php echo anchor("webUser_Controllers/survey_controller/delete_survey/$survey->id", 'Delete Survey', 'class=""'); ?></p>
        <p><?php echo anchor("webUser_Controllers/survey_controller/edit_survey/$survey->id", 'Edit Survey', 'class=""'); ?></p>
    </div>
    <div class="survey_box">
        <h3>Questions</h3>
        <?php
        if (!empty($questions)) {
            echo '<ul>';
            foreach ($questions as $row) {
                echo'<li class="myQuestions">' . $row->question . anchor("webUser_Controllers/survey_controller/check_question_type/$row->id", 'View Responses', 'class="rightlink"') . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>There are no questions for this survey!<p>';
        }
        ?>
    </div>
    <div class="survey_box">
        <h3>Assignments</h3>
        <?php
        if (!empty($assignments)) {
            echo '<ul>';
            foreach ($assignments as $r) {
                echo'<li class="myQuestions">' . $r->managerNotes . anchor("webUser_Controllers/assignment_controller/delete_assignment/$r->id", 'Delete', 'class="rightlink"') .
                anchor("webUser_Controllers/assignment_controller/view_whos_assigned/$r->id", 'View Who Is Assigned', 'class="rightlink"') . '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>You have yet to assign this survey!<p>';
        }
        ?>
    </div>
</div>
