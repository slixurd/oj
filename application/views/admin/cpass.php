        <div class="password pull-right">
            <div>
            <h3>修改密码</h3>
            <div class="row">
                <span style="display:inline-block;width:480px;text-align:left;" >管理员/助教/老师可以通过此功能重置用户密码.强制将用户密码设置为 12345678 ,修改后请同学自己主动修改密码</span>
            </div>
            <div class="row">
                <span style="width:140px;" class="tip">用户名：</span>
                <input class="necessary" type="text" id="userid" />
            </div>
            <div class="row">
                <span style="width:140px;" class="tip">确认用户名：</span>
                <input class="necessary" type="text" id="conf" />
            </div>

            <div class="submit-footer">
                <input id="submit" type="button" class="btn" value="重置" />
            </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#submit').bind('click', function(event) {
        var url,userid,conf;
        url = '<?php echo site_url("/admin/misc/put_cpass") ?>';
        userid = $('#userid').val();
        conf = $('#conf').val();
        if(userid.length == 0) {
            myPopover($('#userid'),'ID不能为空','right');
            event.preventDefault();
        } else if(userid !== conf) {
            myPopover($('#userid'),'两次ID输入不一致','right');
            event.preventDefault();
        }else{
            $.post(url,{user:userid},function(data){
                
            });
        }
        
    });
</script>