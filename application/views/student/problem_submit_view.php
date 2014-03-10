<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<h3>提交回答</h3>
		</div>

		<h4>Problem ID: <span><?php echo $problemId; ?></span></h4>
		<div class="submit-code">
			<form action="<?php echo site_url('problem_submit/submit');if($loc!=0) echo '/'.$loc.'/'.$loc_id;?>" method="post">
				<div>
					<span>语言</span>

					<div class="table-sel">
						<span class="sel-title"><?php if($user['programLan']==NULL) echo 'C++'; else echo $lan[$user['programLan']]; ?></span>
						<i class="ic_ud_sel"></i>
						<select name="language">
							<?php foreach ($lan as $index => $l) { ?>
								<option value='<?php echo $index; ?>' <?php if(($user['programLan']==NULL && $index == 1)|| $user['programLan']===$index ) echo 'selected="selected"'?>><?php echo $l; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div>
					<span>代码</span>
					<textarea name='code' class="textarea"></textarea>		
					<input value='<?php echo $problemId ?>' name='problemId' style="display:none"/>	
				</div>

				<div class="util-block">
					<button class="common-button" type='submit'>提交</button>
					<a href="">Status</a>
				</div>
			</form>
		</div>

	</div>
</div>
