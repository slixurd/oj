        <div class="pull-right">
            <table class="table">
                <caption>××实验\作业</caption>
                <thead>
                    <tr>
                        <th class="span2">ID</th>
                        <th class="span6">标题</th>
                        <th class="span2">删除</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($plist))
                        foreach ($plist as $item) { ?>
                    <tr>
                        <td><?php echo $item['problemId'] ?></td>
                        <td><?php echo $item['title'] ?></td>
                        <td><a class="pdel">删除</a></td>
                    </tr>
                    <?php }else{?>
                        <td colspan='3'> 暂无题目 </td>
                    <?php } ?>
                </tbody>
            </table>

            <div id="problem">
                <table class="table margin-top">
                    <caption>选择已有题目</caption>
                    <thead>
                        <tr>
                            <th class="span1">问题ID</th>
                            <th class="span4">名称</th>
                            <th class="span1">状态</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($problem_list as $item) { ?>
                        <tr>
                            <td><?php echo $item['problemId'] ?></td>
                            <td title="<?php echo $item['title'] ?>"><?php echo $item['title'] ?></td>
                            <td>
                                <div class="checkbox">
                                    <input type="checkbox" name="select" autocomplete="off" />
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="pagination" style="text-align:center;">
                    <ul>
                        <?php echo $pagination_block; ?>
                    </ul>
                </div>
            </div>
            <div class="submit-footer">
                <a href="#" class="btn">返回</a>
                <input type="submit" class="btn" value="添加" />
                <input type="reset" class="btn" value="取消" />
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
//使得网页初始加载时复选框的状态是正确的
    check_box();

//复选框状态改变时动作
//******此处需要成功提交到后台并返回后才会执行相应的动作（此处鼠标貌似不能点击太快）
    $('body').on('change','[type="checkbox"]', function() {
        var url = "<?php echo site_url('admin/course/problem_select/').'/'.$uid ?>";
        var pid = $(this).parents('tr').find('td:first').text();    //问题的ID
        var add;    //告诉后台提交的题目是“选择”还是“撤销选择”，“1”表示选择
        var t = $(this);
        if($(this).prop('checked') == true || $(this).prop('checked') == "checked") {
            add = 1;
            $.getJSON(url, {pid: pid,add: add}, function(data) {
                if(data.status == true) {
                    t.parent().addClass('checked');
                    shrink(t.parents('tr'),$('table').eq(0),true);
                } else {
                    alert(data.reason);
                }
            });
        } else {
            add = 0;
            $.getJSON(url, {pid: pid,add: add}, function(data) {
                if(data.status == true) {
                    t.parent().removeClass('checked');
                    //var id = $(this).parents('tr').children(':first').text();
                    var $trFrom = $('table')
                                .eq(0)
                                .find('tbody tr td:contains("' + pid + '")')
                                .parent();
                    shrink($trFrom,t.parents('tr'),false);
                } else {
                    alert(data.reason)
                }
            });
        }
    });

    $("body").on("click",'.pdel', function(c){
        c.preventDefault();
        var line = $(this).parents('tr');
        var pid = line.find("td:first").text();
        var url = "<?php echo site_url('admin/course/problem_select/').'/'.$uid ?>"+'?pid='+pid+'&add=0';
            $.getJSON(url,function(data){
                if(data.status == true ){
                    line.fadeOut();
                }else{
                    alert(data.reason);
                }
            });
    })
</script>