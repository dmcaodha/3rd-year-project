<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar5">
    <p class="bck_surveys5"><?php echo anchor('webUser_Controllers/survey_controller/back_to_survey', 'Back to Survey'); ?></p>
    <p class="back_link5"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link5"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div class="webUser_manage_mobile">
    <h1 class="mob_view">Mobile Users Assigned</h1>
    <?php if (isset($names)) { ?>
        <table border="1" class="mob_view_table">
            <tr>
                <th>Name</th>
                <th>Delete</th>
            </tr>
            <?php foreach ($names as $r) { ?>
                <tr>
                    <td class="mob_username"><?php echo $r->userName; ?></td>
                    <td class="mob_username"><?php echo anchor("webUser_Controllers/assignment_controller/delete_mob_user_from_assignment/$r->id", '<img src="../../../../images/delete.png" alt="delete" />'); ?></td>
                </tr>
        <?php } // End foreach 
    ?>
        </table>
            <?php
        } // End if statement
        else {
            echo '<p>There are no assignments found!</p>';
        }
        ?>
</div>
<script type="text/javascript">
    $('tr:odd').css('background', '#e3e3e3');
</script>
