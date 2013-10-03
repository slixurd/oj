
<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<div class="search">
				<div class="search-wrapper">
					<button>S</button>
					<span>ID <img src="/scutoj/assets/img/list_button.png"></span>
					<input />
				</div>
			</div>
			<h3>题集</h3>
		</div>

		<table class="table">
			<thead>
				<tr>
					<th class="span2">ID</th>
					<th class="span5">题目名称</th>
					<th class="span2">AC总数</th>
					<th class="span2">提交总数</th>
					<th class="span1">状态</th>
				</tr>
			</thead>
			<tbody>				
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




