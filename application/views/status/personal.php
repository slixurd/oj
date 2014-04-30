<div>
    <div class="judge">
        <p><img src="<?php echo base_url("assets") ?>/img/web_loading.gif"><span id="result">判题中</span></p>
        <p class="notify-flush"><span id="timer">3</span>秒后自动刷新结果</p>
    </div>
</div>

<script type="text/javascript">
function get_result(){
    $.getJSON("<?php echo site_url('status/update_result')?>",function(json){
        if(json.code<4){
            $("#timer").html()=3;
            setTimeout('time_minus()',1000);
            setTimeout('get_result()',1000); //指定3秒刷新一次
        }else if(json.code>=4){
            $("#result").html(json.status);
            $(".notify-flush").html("结果已出,可以返回首页");
        }
    });
}
    //window.location.href='<?php echo site_url("status") ?>'; 

setTimeout('get_result()',3000); //指定3秒刷新一次
function time_minus(){
    if($("#timer").html()>=1){
        $("#timer").html($("#timer").html()-1);
        setTimeout('time_minus()',1000);
    }
}

setTimeout('time_minus()',1000);


</script>
