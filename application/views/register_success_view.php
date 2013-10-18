<div class="wrapper">
	<div class="noback">
		<div class="nbc">
			<img src="<?php echo base_url("assets") ?>/img/succeed.png">
			<div class="inform">
				<h3>啊哈哈.注册成功了!</h3>
				<p>盯着我看3秒就会回到注册前的页面了</p>
			</div>
		</div>
	</div>
</div>

<script>
function back()
{
	history.go(-2);
}
setTimeout('back()',3000); //指定1秒刷新一次
</script>