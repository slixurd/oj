
<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<div class="search">
				<form class="search-wrapper" action="<?php echo site_url("problem/index"); ?>" method="post">
					<button class="search-button" type="submit"><img src="<?php echo base_url("assets") ?>/img/search.png"></button>
					<span id="search-method">
						<span>ID</span><img src="<?php echo base_url("assets") ?>/img/list_button.png">
						<ul>
							<li><span class="s_id">ID</span></li>
							<li><span class="s_title">题目</span></li>
						</ul>
					</span>
					<input name="s_id" type="text" />
				</form>
			</div>
			<h3>题集</h3>
		</div>

		<table id="problem-list" class="table">
			<thead>
				<tr>
					<th class="span2">ID</th>
					<th class="span5">题目名称</th>
					<th class="span2">AC总数</th>
					<th class="span2">提交总数</th>
					<th class="span1">状态</th>
				</tr>
			</thead>
			<tbody class="pointer">			
				<?php if(isset($is_empty)) 
					echo "<tr><td colspan='5' class='empty-answer'>搜索结果为空</td></tr>"
				?>	
				<?php foreach($problem_list as $problem): ?>
				<tr>
					<td><?php echo $problem['problemId'] ?></td>
					<td><?php echo $problem['title'] ?></td>
					<td><?php echo $problem['accepted'] ?></td>
					<td><?php echo $problem['submit'] ?></td>
					<td><?php echo $problem['status'] ?></td>
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




