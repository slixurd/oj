        <div class="authority pull-right">
            <table class="table">
                <caption>高权限用户列表</caption>
                <thead>
                    <tr>
                        <th class="span3">用户ID</th>
                        <th class="span3">用户</th>
                        <th class="span4">权限</th>
                        <th class="span2">删除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plist as $item) { ?>
                        <tr>
                            <td><?php echo $item['userId']; ?> </td>
                            <td><?php echo $item['name']; ?></td>
                            <td><?php echo $item['type']; ?></td>
                            <td><a class="pdel" href="#">删除</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="margin-top">
                <h3>类型设置</h3>
                <div class="row">
                    <span class="tip">用户名：</span>
                    <input type="text" id="userid1" />
                </div>
                <div class="row">
                    <span class="tip">权限类型：</span>
                    <div class="select-down">
                        <span class="select-down-span">管理员<i class="down"></i></span>
                        <select id="type1" class="select-down-select">
                            <option value="0">管理员</option>
                            <option value="1">老师</option>
                            <option value="2">助教</option>
                        </select>
                    </div>

                </div>
                <div class="submit-footer" style="padding-top:0">
                    <input id="submit1" type="button" class="btn" value="确认修改" />
                </div>
                <div style="width:450px;margin:20px auto;">添加了助教身份后需要设置助教允许修改的课程/竞赛ID,否则没有添加删除的权限</div> 
                <hr />
                <h3>权限设置</h3>

                <div class="row">
                    <span class="tip">用户名：</span>
                    <input type="text" id="userid2" />
                </div>
                <div class="row">
                    <span class="tip">类型选择：</span>
                    <div class="select-down">
                        <span class="select-down-span">课程<i class="down"></i></span>
                        <select id="type2" class="select-down-select">
                            <option value="0">课程</option>
                            <option value="1">竞赛</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <span style="width:100px;" class="tip">课程/竞赛ID：</span>
                    <input type="text" id="commonId" />
                </div>
                <!-- div class="row">
                        <span class="tip">权限：</span>
                    <div style="display:inline-block;width:195px;vertical-align:middle;text-align:left">
                        <input id="read" style="margin:0 5px 0 10px" type="checkbox" />r
                        <input id="write" style="margin:0 5px 0 40px" type="checkbox" />w
                        <input id="exec" style="margin:0 5px 0 40px" type="checkbox" />x
                    </div>
                </div -->
                <div class="submit-footer" style="padding-top:0">
                    <input id="submit2" type="button" class="btn" value="确认修改" />
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    doSelect();

    $('.pdel').bind('click', function(event) {
        $.post(url,{userid: userid,type: type},function(data){
            $(this).parents('tr').fadeOut();   

        },"json");
    });

    $("#submit1").bind('click', function(event) {
        var url,username,type;
        url = '<?php echo site_url("admin/misc/update_type") ?>';
        username = $('#userid1').val();
        type = $('#type1').val();
        if(username.length == 0) {
            myPopover($('#userid1'),'用户名不能为空','right');
            return false;
        }
        $.post(url,{username: username,type: type},function(data){
            if(data.status == true )
                 window.location.reload();
             else
                alert(data.reason);
        },"json");
    });



    $("#submit2").bind('click', function(event) {
        var url,userid,type,authority,read,write,exec;
        url = '<?php echo site_url("admin/misc/update_pri") ?>';
        userid = $('#userid2').val();
        if(userid.length == 0) {
            myPopover($('#userid2'),'ID不能为空','right');
            return false;
        }
        type = $('#type2').val();
        cid = $("#commonId").val();

        $.post(url,{ userid: userid, type: type, cid : cid},function(data){
            if(data.status == true )
                 window.location.reload();
             else
                alert(data.reason);
        },"json");
        
    });
</script>