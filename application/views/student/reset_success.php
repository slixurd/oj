<div class="wrapper">
	<div class="noback">
		<div class="nbc">
			<img src="<?php echo base_url("assets") ?>/img/succeed.png">
			<div class="inform">
				<h3>重置密码成功!</h3>
				<p>3秒后回到主页</p>
			</div>
		</div>
	</div>
</div>

<script>
<script type='text/javascript'>  
function go(){
    window.location.href='<?php echo site_url() ?>'; 
}
    setTimeout('go()',3000) 
</script>