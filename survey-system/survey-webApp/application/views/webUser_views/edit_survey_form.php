<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar5">
    <p class="bck_surveys5"><?php echo anchor('webUser_Controllers/survey_controller/back_to_survey', 'Back to Survey'); ?></p>
    <p class="back_link5"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link5"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<h1 class="mob_view_admin">Edit</h1>
<?php echo form_open('webUser_Controllers/survey_controller/update_survey'); ?>
<fieldset>
    <legend>Edit Survey</legend>
    <?php
    if (isset($survey)) {
        echo form_hidden('id', $id);
        echo '<p class="input_label">Title</p>';
        echo form_input('title', $survey->title);
        echo '<p class="input_label">Topic</p>';
        echo form_input('topic', $survey->topic);
        echo form_submit('submit', 'Save Survey');
    } //end if statement
    else {
        echo "data wasn't set";
    }
    ?>
</fieldset>
<?php echo form_close(); ?>
<div>
    <h1 class="error_head">Drag and drop the questions to change their order...</h1>
    <?php
    if (!empty($questions)) {
        echo '<ul id="question_list">';
        foreach ($questions as $row) {
            echo'<li id="sort_' . $row->id . '">' . $row->question . ' ' . $row->position . '</li>';
        }
        echo '</ul>';
    } else {
        echo '<h1 class="error_head">There are no questions for this survey!</h1>';
    }
    ?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#question_list").sortable({
            opacity: 0.3,
            cursor: 'move',
            update : function () {
                var info = $(this).sortable('serialize');
                $.ajax({
                    type: "POST",
                    // Need to fix this to the base_url
                    url: "http://172.17.0.31/~N00094747/survey_webApp/index.php/webUser_Controllers/question_controller/sort_questions",
                    data: info,
                    context: document.body,
                    success: function(){
                        alert("success");
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        alert("error: " +  jqXHR.statusText);
                    }
                });

            }
        });
    });
</script>
