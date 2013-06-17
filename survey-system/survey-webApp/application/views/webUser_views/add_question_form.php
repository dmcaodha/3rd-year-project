<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar">
    <p class="back_link"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="add_question_form">
    <h1>Title: <?php echo $title; ?></h1>
    <h1>Topic: <?php echo $topic; ?></h1>
    <?php echo form_open('webUser_Controllers/question_controller/add_question_validate'); ?>
    <fieldset>
        <legend>Add Your Question</legend>
        <?php
        $info = array('name' => 'question', 'cols' => 35, 'rows' => 6, 'value' => set_value('question'));
        echo '<p class="input_label">Enter Your Question Below</p>';
        echo form_textarea($info);
        echo '<br/>';
        $options = array(
            'null' => 'Choose a Question Type',
            'text' => 'Text',
            'multi3' => '3 Option Multi-Choice',
            'multi5' => '5 Option Multi-Choice',
            'rating' => '5 Star Rating'
        );
        echo form_dropdown('type', $options, 'null', 'id="questionType"') . '<br />';
        ?>
        <!-- This div only appears when the user selects multi choice 3 from the dropdown list
             and is handled by the script at the bottom of the page. -->
        <div id="multi3choices">
            <?php
            echo '<p class="input_label">Choice 1</p>';
            echo form_input(array('name' => 'choice1', 'class' => 'multiChoice', 'value' => set_value('choice1'))) . '<br />';
            echo '<p class="input_label">Choice 2</p>';
            echo form_input(array('name' => 'choice2', 'class' => 'multiChoice', 'value' => set_value('choice2'))) . '<br />';
            echo '<p class="input_label">Choice 3</p>';
            echo form_input(array('name' => 'choice3', 'class' => 'multiChoice', 'value' => set_value('choice3'))) . '<br />';
            ?>
        </div>
        <!-- This div only appears when the user selects multi choice 5 from the dropdown list
             and is handled by the script at the bottom of the page. -->
        <div id="multi5choices">
            <?php
            echo '<p class="input_label">Choice 4</p>';
            echo form_input(array('name' => 'choice4', 'class' => 'multiChoice', 'value' => set_value('choice4'))) . '<br />';
            echo '<p class="input_label">Choice 5</p>';
            echo form_input(array('name' => 'choice5', 'class' => 'multiChoice', 'value' => set_value('choice5'))) . '<br />';
            ?>
        </div>
        <?php
        echo form_hidden('surveyId', $this->session->userdata('surveyId'));
        // This gives the question a position in the survey
        if (!empty($rows)) {
            echo form_hidden('position', count($rows));
        } else {
            echo form_hidden('position', 0);
        }
        echo form_submit('submit', 'Add Question');
        ?>

        <?php echo validation_errors('<p class="error">'); ?>
    </fieldset>
    <br />
    <fieldset>
        <legend>Questions</legend>

        <?php
        if (!empty($rows)) {
            echo '<ol>';
            foreach ($rows as $row) {
                ?>
                <li><?php echo $row->question; ?></li>
                <?php
            }
            echo '</ol>';
        } else {
            echo '<p>There are no questions yet!</p>';
        }
        echo form_submit('submit', 'Save Survey');
        ?>
    </fieldset>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" >
    $('#multi3choices').hide();
    $('#multi5choices').hide();
    $('#questionType').change(function() {
        var value = $(this).attr('value');
        if (value == 'multi3') {
            $('#multi3choices').show();
            $('#multi5choices').hide();
        }
        else if (value == 'multi5') {
            $('#multi3choices').show();
            $('#multi5choices').show();
        }
        else {
            $('#multi3choices').hide();
            $('#multi5choices').hide();
        }
    });
</script>
