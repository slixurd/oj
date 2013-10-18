
<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<div class="search">
				<form class="search-wrapper" action="<?php echo site_url("contest/index"); ?>" method="post">
					<button class="search-button" type="submit"><img src="<?php echo base_url("assets") ?>/img/search.png"></button>
					<span id="search-method">
						<span>ID</span><img src="<?php echo base_url("assets") ?>/img/list_button.png">
						<ul>
							<li><span class="s_id">ID</span></li>
							<li><span class="s_title">名称</span></li>
						</ul>
					</span>
					<input name="s_id" type="text" />
				</form>
			</div>
			<h3>比赛</h3>
		</div>

		<table id="contest-list" class="table">
			<thead>
				<tr>
					<th class="span2">比赛ID</th>
					<th class="span3">比赛名称</th>
					<th class="span3">开始时间</th>
					<th class="span3">结束时间</th>
					<th class="span1">私有</th>
				</tr>
			</thead>
			<tbody class="pointer">			
				<?php foreach($contest_list as $contest): ?>
				<tr>
					<td><?php echo $contest['contestId'] ?></td>
					<td><?php echo $contest['title'] ?></td>
					<td><?php echo $contest['startTime'] ?></td>
					<td><?php echo $contest['endTime'] ?></td>
					<td><?php echo $contest['private']?"是":"否"; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<!-- hr class="bottom-hr" / -->

	  	<div class="pagination" style="text-align:center;">
		  <ul>
	  	  	<?php echo $pagination_block; ?>
		    <!--li class="active"><a href="">1</a></li -->
		  </ul>
		</div>
	</div>
</div>




