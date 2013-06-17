<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar3">
    <p class="manamob_links"><?php echo anchor('webUser_Controllers/manage_mobile_users/load_create_mobile_user_form', 'Create Mobile Account'); ?></p>
    <p class="back_link3"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link3"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div class="webUser_manage_mobile">
    <h1 class="mob_view">Your Mobile Accounts</h1>
    <?php if (isset($rows)) { ?>
        <table border="1" class="mob_view_table">
            <tr>
                <th>UserName</th>
                <th>Delete</th>
                <th>Edit</th>
            </tr>
            <?php foreach ($rows as $r) { ?>
                <tr>
                    <td class="mob_username"><?php echo $r->userName; ?></td>
                    <td class="mob_align"><?php echo anchor("webUser_Controllers/manage_mobile_users/delete_mobile_account/$r->id", '<img src="../../../images/delete.png" alt="delete" />'); ?></td>
                    <td class="mob_align"><?php echo anchor("webUser_Controllers/manage_mobile_users/load_edit_mobile_account_form/$r->id", '<img src="../../../images/edit.png" alt="edit" />'); ?></td>
                </tr>
        <?php } // End foreach 
    ?>
        </table>
            <?php
        } // End if statement
        else {
            echo '<h1 class="error_head">You have not added any mobile user accounts...</h1>';
        }
        ?>
</div>
<script type="text/javascript">
    $('tr:odd').css('background', '#e3e3e3');
</script>
