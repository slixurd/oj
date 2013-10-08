<?php echo validation_errors(); ?>

<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<h3>注册</h3>
		</div>
		<div class="reg-indicator">
			<strong>欢迎来到全新的SCOJ Milestone1.0！</strong>
			<p>在‘课程’目录下，你可以参加即将进行的实验和比赛</p>
			<p>寻求帮助？请点击‘帮助’</p>
			<p>有什么意见或建议给UP主，请戳→ <a href="https://gitcafe.com/SCOJ/scoj">GIT</a></p>

			<p>Now,注册你的信息，加入我们</p>
			<p>和小伙伴们一起，开始你的刷题之旅吧！''</p>
		</div>
		<form class="register"  method="post"  action="<?php echo site_url("user/register_submit"); ?>">
			<!-- div>
				<span>ID</span>
				<input name="id"/>
			</div -->
			<div>
				<span>昵称</span>
				<input id="username-reg"  name="username" required="required"/>
				<span id="username-status"></span>
			</div>
			<div>
				<span>密码</span>
				<input id="pa-reg" name="pa" type="password" required="required"/>
				<span id="pa-status"></span>
			</div>
			<div>
				<span>确认密码</span>
				<input id="paconf-reg" name="paconf" type="password" required="required"/>
				<span id="paconf-status"></span>
			</div>
			<div>
				<span>邮箱</span>
				<input id="email-reg" name="email" type="email" required="required"/>
				<span id="email-status"></span>
			</div>
			<div>
				<span>学校</span>
				<input />
			</div>
			<div>
				<span></span>
				<button id="submit-reg" type="submit" class="common-button">提交注册</button>
			</div>
		</form>

	</div>
</div>
