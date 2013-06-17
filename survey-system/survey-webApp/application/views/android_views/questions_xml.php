<?php
// Daniel McKay & Ronan Reilly 2012 

header("Content-type: text/xml");
?>
<questions>
    <?php foreach ($questions as $row) { ?>
        <question id="<?php echo $row['id']; ?>">
            <questtext><?php echo $row['question']; ?></questtext>
            <type><?php echo $row['type']; ?></type>
            <position><?php echo $row['position']; ?></position>
            <?php if ($row['type'] == 'multi3' || $row['type'] == 'multi5') { ?>
                <possanswers>
                    <choice1><?php echo $row['choice1']; ?></choice1>
                    <choice2><?php echo $row['choice2']; ?></choice2>
                    <choice3><?php echo $row['choice3']; ?></choice3>
                    <?php if ($row['type'] == 'multi5') { ?>
                        <choice4><?php echo $row['choice4']; ?></choice4>
                        <choice5><?php echo $row['choice5']; ?></choice5>
                    <?php }  //end if ?>
                </possanswers>
                <?php
            }   //end if
            ?>
        </question>
        <?php
    }   //end foreach
    ?>
</questions>