<?php echo validation_errors(); ?>

<div class="wrapper">
	<div class="container">
		<div class="sub-header">
			<h3>注册</h3>
		</div>
		<div class="reg-indicator">
			<span>这里是注册提示啊提示.这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示这里是注册提示啊提示</span>
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
				<input id="email-reg" name="email-reg" type="email" required="required"/>
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
