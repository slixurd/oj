<div class="wrapper">
	<div class="container side-split">
		<div class="side-appendix">
			<div class="problem-appendix">
				<div><span>题号</span><span><?php echo $problem['problemId'] ?></span></div>
				<div><span>时间限制</span><span><?php echo $problem['timeLimit']."ms" ?></span></div>
				<div><span>内存限制</span><span><?php echo $problem['memoryLimit']."M" ?></span></div>
				<div><span>通过总数</span><span><?php echo $problem['accepted'] ?></span></div>
				<div><span>提交总数</span><span><?php echo $problem['submit'] ?></span></div>
			</div>

		</div>
		<div class="side-main">
			<div class="sub-header">
				<h3><?php echo $problem['title'] ?></h3>
			</div>
			<div class="problem-info">
				<div>
					<h4>问题描述</h4>
					<span>
						<?php echo $problem['description'] ?>
					</span>
				</div>			
				<div>
					<h4>输入描述</h4>
					<span>
						<?php echo $problem['input'] ?>
					</span>
				</div>			
				<div>
					<h4>输出描述</h4>
					<span>
						<?php echo $problem['output'] ?>
					</span>
				</div>			
				<div>
					<h4>输入示例</h4>
					<span><?php echo $problem['sampleInput'] ?></span>
				</div>			
				<div>
					<h4>输出示例</h4>
					<span><?php echo $problem['sampleOutput'] ?></span>
				</div>			
				<div>
					<h4>Hint</h4>
					<span><?php echo $problem['hint'] ?></span>
				</div>			
				<div>
					<h4>来源</h4>
					<span><?php echo $problem['source'] ?></span>
				</div>	
				<div class="button-side">
					<button class="common-button">提交</button>
					<button class="common-button">状态</button>
				</div>		
			</div>


		</div>

	</div>
</div>
