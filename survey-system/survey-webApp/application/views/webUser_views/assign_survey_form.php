<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar2">
    <p class="bck_surveys5"><?php echo anchor('webUser_Controllers/survey_controller/back_to_survey', 'Back to Survey'); ?></p>
    <p class="create_link2"><?php echo anchor('webUser_Controllers/manage_mobile_users/load_create_mobile_user_form', 'Create Mobile Account'); ?></p>
    <p class="back_link2"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link2"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div class="webUser_manage_mobile">
    <h1 class="mob_view">Assign Survey</h1>
    <?php if (isset($rows)) { ?>
        <?php
        echo form_open('webUser_Controllers/assignment_controller/assign_survey_validate');
        echo form_hidden('surveyId', $surveyId);
        echo '<p class="input_label">Notes</p>';
        $info = array('name' => 'managerNotes', 'class' => 'textbox', 'cols' => 48, 'rows' => 3);
        echo form_textarea($info);
        ?>
        <table border="1" class="mob_view_table">
            <tr>
                <th>UserName</th>
                <th>Assign</th>
            </tr>
            <?php foreach ($rows as $r) { ?>
                <tr>
                    <td class="mob_username"><?php echo $r->userName; ?></td>
                    <td class="mob_username"><?php echo form_checkbox('assign[]', $r->id, FALSE); ?></td>
                </tr>
                <?php
            } // End foreach
            ?>
        </table>
        <?php
        echo form_submit('submit', 'Assign Survey');
        echo validation_errors('<p class="error">');
        echo form_close();
    } // End if statement
    else {
        echo '<h1 class="mob_view">You have not added any mobile accounts yet!</h1>';
    }
    ?>
</div>
<p>&nbsp;</p>
<script type="text/javascript">
    $('tr:odd').css('background', '#e3e3e3');
</script>