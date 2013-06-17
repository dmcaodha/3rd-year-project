<!DOCTYPE html>
<!-- Daniel McKay & Ronan Reilly 2012 -->
<html>
    <head>
        <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
        <title>View Multi Choice 5 Answers</title>
        <link href="<?php echo base_url(); ?>dataVisExtras/css/basic.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo base_url(); ?>dataVisExtras/-shared/EnhanceJS/enhance.js"></script>
        <script type="text/javascript">
            // Run capabilities test
            enhance({
                loadScripts: [
                    {src: '<?php echo base_url(); ?>dataVisExtras/js/excanvas.js', iecondition: 'all'},
                    '<?php echo base_url(); ?>dataVisExtras/-shared/jquery.min.js',
                    '<?php echo base_url(); ?>dataVisExtras/js/visualize.jQuery.js',
                    '<?php echo base_url(); ?>dataVisExtras/js/example-editable.js'
                ],
                loadStyles: [
                    '<?php echo base_url(); ?>dataVisExtras/css/visualize.css',
                    '<?php echo base_url(); ?>dataVisExtras/css/visualize-dark.css'
                ]
            });
        </script>
        <style type="text/css">
            table { float: left; margin: 100px 70px 0px 50px;  }
            .td{background-color: #feeeee;}
            th.pos_answers{background-color: #80ae67}
            .visualize { float: left; }
            .webUser_gen_toolbar7{border: 1px solid white;padding: 2em;-moz-border-radius: 3px;width:340px; margin:auto;margin-bottom: 0px;margin-top: 20px;background: #cdcdcd;}
            .back_link7{font-size: 12pt;display: inline;padding-right: 1em;}
            .logout_link7{font-size: 12pt;display: inline;}
            .create_link7{font-size: 12pt;display: inline;padding-right: 1em;}
            .help7{font-size: 12pt;display: inline;padding-right: 1em;}
        </style>
    <body>
        <div id="container">
            <div class="webUser_gen_toolbar7">
                <p class="create_link7"><?php echo anchor('webUser_Controllers/survey_controller/back_to_survey', 'Back To Survey'); ?></p>
                <p class="back_link7"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
                <p class="logout_link7"><?php echo anchor('login/logout', 'Logout'); ?></p>
            </div>
            <table>
                <caption>Question: <?php echo $question->question; ?></caption>
                <tbody>
                    <tr>
                        <th class="pos_answers">Possible Answers</th>
                        <th class="pos_answers">Times Chosen</th>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo $choices->choice1; ?></th>
                        <td class="td"><?php echo $choice_one_ans->total; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo $choices->choice2; ?></th>
                        <td class="td"><?php echo $choice_two_ans->total; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo $choices->choice3; ?></th>
                        <td class="td"><?php echo $choice_three_ans->total; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo $choices->choice4; ?></th>
                        <td class="td"><?php echo $choice_four_ans->total; ?></td>
                    </tr>
                    <tr>
                        <th scope="row"><?php echo $choices->choice5; ?></th>
                        <td class="td"><?php echo $choice_five_ans->total; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>



