<?php foreach($contest_list as $contest): ?>
<?php echo $contest['contestId']." " ?>
<?php echo $contest['title']." " ?>
<?php echo $contest['endTime']." " ?>
<?php echo $contest['private']."</br>" ?>
<?php endforeach ?>
<div class="pagination" style="text-align:center;">
		  <ul>
	  	  	<?php echo $pagination_block; ?>
		    <!--li class="active"><a href="">1</a></li -->
		  </ul>
		</div>




