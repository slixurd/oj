<?php if($permission=="yes"): ?>
<?php echo "contest name:".$contest_item['title']."</br>" ?>
<?php echo "startTime:".$contest_item['startTime']."</br>" ?>
<?php echo "startTime:".$contest_item['endTime']."</br>" ?>
<?php echo "private:".$contest_item['private']."</br>" ?>
</br></br>

<?php foreach($contest_problem_list as $contest_problem): ?>
<?php echo "problemId:".$contest_problem['problemId']." " ?>
<?php echo "contest_problem_title:".$contest_problem['contest_problem_title']." " ?>
<?php echo "peoblemTitle:".$contest_problem['title']." " ?>
<?php echo "num:".$contest_problem['num']." " ?>
<?php echo "source:".$contest_problem['source']." " ?>
<?php echo "AC:".$contest_problem['accepted']." " ?>
<?php echo "Submit:".$contest_problem['submit']." " ?>
</br></br>
<?php endforeach; ?>
<?php else : ?>
<h1>you have no permision for the contest</h1>
<?php endif; ?>
