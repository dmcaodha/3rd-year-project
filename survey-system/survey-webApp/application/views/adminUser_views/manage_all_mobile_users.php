<!doctype html>
<!-- Daniel McKay & Ronan Reilly 2012 -->
<html lang="en">
    <head>
        <title>Administration -> Manage Mobile User Accounts</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" type="text/css" href="main.css">
        <link rel="stylesheet" type="text/css" href="http://jquery-ui.googlecode.com/svn/tags/1.7.2/themes/redmond/jquery-ui.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="../../../jquery/jquery_paginate.js"></script>

        <script type="text/javascript">
            $(function(){
                $("TABLE#tableOne").paginate({ limit: 10, content: 'TBODY TR' });
            });
        </script><!-- javascript -->
    </head><!-- HEAD -->
    <body>
        <div class="adminUser_manage_mobile2">
            <p class="create_mob"><?php echo anchor('adminUser_Controllers/adminUser_homepage/load_create_mobile_user_form', 'Create Mobile User Account'); ?></p>
            <p class="back_to_dash"><?php echo anchor('adminUser_Controllers/adminUser_homepage/index', 'Back To Dashboard'); ?></p>
            <p class="logout"><?php echo anchor('login/logout', 'Logout'); ?></p>
        </div>
        <div id="admin_form_mob_view">
            <h1 class="mob_view_admin">All Mobile User Accounts</h1>
            <?php if (isset($rows)) { ?>
                <table border="1" id="tableOne">
                    <thead>
                        <tr>
                            <th class="web_view_th">Username</th>
                            <th class="web_view_th">Delete</th>
                            <th class="web_view_th">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) { ?>
                            <tr>
                                <td class="mob_view_td"><?php echo $r->userName; ?></td>
                                <td class="mob_view_td"><?php echo anchor("adminUser_Controllers/adminUser_homepage/delete_mobile_account/$r->id", '<img src="../../../images/delete.png" alt="delete" />'); ?></td>
                                <td class="mob_view_td"><?php echo anchor("adminUser_Controllers/adminUser_homepage/load_edit_mobile_account_form/$r->id", '<img src="../../../images/edit.png" alt="edit" />'); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table><!-- TABLE -->
                <?php
            } // End if statement
            else {
                echo '<h1 class="error_head">There are no mobile users in the system.</h1>';
            }
            ?>
        </div><!-- DIV#table -->
        <script type="text/javascript">
            $('tr:odd').css('background', '#e3e3e3');
            $('tr:even').css('background', '#d5d5d5');
        </script>
    </body><!-- BODY -->
