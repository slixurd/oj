<div class="wrapper">
	<div class="noback">
		<div class="nbc">
			<img src="<?php echo base_url("assets") ?>/img/master.png">
			<div class="inform">
				<h3>注册失败</h3>
				<p>抱歉,您请求了非法的数据或者网络传输出现了问题</p>
				<p>3秒后回到上一页</p>
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
