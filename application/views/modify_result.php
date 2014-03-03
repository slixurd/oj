
<div class="wrapper">
    <div class="noback">
        <div class="nbc">
            <img src="<?php echo base_url("assets") ?>/img/succeed.png">
            <div class="inform">
                <h3>啊哈哈.修改密码成功!</h3>
                <p>3秒后返回主页，需要重新登陆</p>
            </div>
        </div>
    </div>
</div>
<script type='text/javascript'>  
function go(){
    window.location.href='<?php echo site_url() ?>'; 
}
    setTimeout('go()',3000) 
</script>