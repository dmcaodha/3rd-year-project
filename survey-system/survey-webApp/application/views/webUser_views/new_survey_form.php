<!-- Daniel McKay & Ronan Reilly 2012 -->
<div class="webUser_gen_toolbar_1">
    <!-- Help Link -->
    <p class="back_link"><?php echo anchor('webUser_Controllers/webUser_homepage/index', 'Back To Dashboard'); ?></p>
    <p class="logout_link"><?php echo anchor('login/logout', 'Logout'); ?></p>
</div>
<div id="new_survey_form">
    <h1>Build A Survey</h1>
    <?php echo form_open('webUser_Controllers/survey_controller/create_survey'); ?>
    <fieldset>
        <legend>New Survey</legend>
        <?php
        echo '<p class="input_label">Title</p>';
        echo form_input('title', set_value('title'));
        echo '<p class="input_label">Topic</p>';
        echo form_input('topic', set_value('topic'));
        echo form_submit('submit', 'Create Survey');
        ?>

        <?php echo validation_errors('<p class="error">'); ?>
    </fieldset>
    <?php echo form_close(); ?>
</div>

