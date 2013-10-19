<div class="wrapper">
	<div class="container">
		<div class="side-main">
			<div class="sub-header center">
				<h3><?php echo $problem['problemId'] ?>:<?php echo $problem['title'] ?></h3>
			</div>			
			<table class="problem-brief">
				<tr>
					<td>Time:<?php echo $problem['timeLimit']."ms" ?></td>
					<td>Memory:<?php echo $problem['memoryLimit']."M" ?></td>
				</tr>
				<tr>
					<td>Submit:<?php echo $problem['submit'] ?></td>
					<td>Pass:<?php echo $problem['submit']-$problem['accepted'] ?></td>
				</tr>
			</table>
			<div class="problem-info">
				<div>
					<div class="detail-title">问题描述</div>
					<span>
						<?php echo $problem['description'] ?>
					</span>
				</div>			
				<div>
					<div class="detail-title">输入描述</div>
					<span>
						<?php echo $problem['input'] ?>
					</span>
				</div>			
				<div>
					<div class="detail-title">输出描述</div>
					<span>
						<?php echo $problem['output'] ?>
					</span>
				</div>			
				<div>
					<div class="detail-title">输入示例</div>
					<span><?php echo $problem['sampleInput'] ?></span>
				</div>			
				<div>
					<div class="detail-title">输出示例</div>
					<span><?php echo $problem['sampleOutput'] ?></span>
				</div>			
				<div>
					<div class="detail-title">Hint</div>
					<span><?php echo $problem['hint'] ?></span>
				</div>			
				<div>
					<div class="detail-title">来源</div>
					<span><?php echo $problem['source'] ?></span>
				</div>	
				<div class="button-side">
					<button class="common-button" onclick="window.location.href = '<?php echo site_url("problem_submit") ?>'">提交</button>
					<button class="common-button">状态</button>
				</div>		
			</div>


		</div>

	</div>
</div>
