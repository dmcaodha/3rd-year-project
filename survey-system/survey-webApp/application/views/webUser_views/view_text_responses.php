<!doctype html>
<!-- Daniel McKay & Ronan Reilly 2012 -->
<html lang="en">
    <head>
        <title>View Text Responses</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css" type="text/css" media="screen">
        <link rel="stylesheet" type="text/css" href="http://jquery-ui.googlecode.com/svn/tags/1.7.2/themes/redmond/jquery-ui.css">

        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
        <script type="text/javascript" src="../../../../jquery/jquery_paginate.js"></script>
        <script type="text/javascript">
            $(function(){
                $("TABLE#tableResponse").paginate({ limit: 10, content: 'TBODY TR' });
            });
        </script><!-- javascript -->
    </head><!-- HEAD -->
    <body>
        <div class="webUser_gen_toolbar7">
            <p class="create_link7"><?php echo anchor('webUser_Controllers/survey_controller/back_to_survey', 'Back To Survey'); ?></p>
            <p class="back_link7"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
            <p class="logout_link7"><?php echo anchor('login/logout', 'Logout'); ?></p>
        </div>
        <div id="text_response_container">
            <h1 class="mob_view"><?php echo $question->question; ?></h1>
            <?php if (isset($rows)) { ?>
                <table border="1" id="tableResponse">
                    <thead>
                        <tr>
                            <th class="web_view_th">Answer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($rows as $r) { ?>
                            <tr>
                                <td class="web_view"><?php echo $r->answerText; ?></td>
                            </tr>           <?php } ?>
                    </tbody>
                </table><!-- TABLE -->
                <?php
            } else {
                echo '<h1 class="error_head">There are no responses for this question yet!<h1>';
            }
            ?>
        </div><!-- DIV#table -->
        <script type="text/javascript">
            $('tr:odd').css('background', '#e3e3e3');
        </script> 
    </body><!-- BODY -->
