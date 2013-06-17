<?php
// Daniel McKay & Ronan Reilly 2012 
header("Content-type: text/xml");
?>
<assignments userId="<?php echo $id; ?>">
    <?php foreach ($assignments as $row) { ?>
        <assignment id="<?php echo $row['assignId']; ?>">
            <dateAssigned><?php echo $row['dateAssigned']; ?></dateAssigned>
            <managerNotes><?php echo $row['managerNotes']; ?></managerNotes>
            <survey id="<?php echo $row['surveyId']; ?>">
                <title><?php echo $row['title']; ?></title>
                <topic><?php echo $row['topic']; ?></topic>
            </survey>
        </assignment>
    <?php }  //end foreach
    ?>
</assignments>