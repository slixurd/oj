<h1><?php echo "It a test !"; ?></h1>
<?php foreach($problem_list as $problem): ?>
<?php echo $problem['title']."  ".$problem['problemId'] ?><br>
<?php endforeach; ?>
