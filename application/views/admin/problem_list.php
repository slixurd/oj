

        <div  class="problem-list pull-right">
            <table class="table">
                <caption>题目列表</caption>
                <thead>
                    <tr>
                        <th class="span1">问题ID</th>
                        <th class="span6">名称</th>
                        <th class="span6">时间</th>
                        <th class="span3">状态</th>
                        <th class="span1">删除</th>
                        <th class="span1">编辑</th>
                        <th class="span2">测试数据</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($problem_list as $item) { ?>
                    <tr>
                        <td class="pid"><?php echo $item['problemId'] ?></td>
                        <td class="avoid-overflow" title="<?php echo $item['title'] ?>"><?php echo $item['title'] ?></td>
                        <td><?php echo $item['inDate'] ?></td>
                        <td>
                            <div class="select-down"> 
                                <span class="select-down-span status-span"><?php echo $item['defunct'] === "0"?"Available":"Reserved" ?><i class="down"></i></span>
                                <select class="select-down-select" name="status" autocomplete="off">
                                    <option value="available" <?php if($item['defunct'] === "0") echo 'selected="selected"' ?> >Available</option>
                                    <option value="reserved" <?php if($item['defunct'] === "1") echo 'selected="selected"' ?>>Reserved</option>
                                </select>
                            </div>
                        </td>
                        <td><a class="pdel">删除</a></td>
                        <td><a href="#">编辑</a></td>
                        <td><a href="#">测试数据</a></td>
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
        <div class="clearfix"></div>
    </div>
</div>
<script type="text/javascript" src="<?php echo base_url("assets") ?>/js/bootstrap.js"></script>

<script type="text/javascript">
    //实现下拉列表的动作
    $(".select-down > select").change(function() {
        var value = this.value;
        var text = $(this).find("option[value="+value+"]").text();
        $(this).siblings("span").text(text)
                .append("<i class='down'></i>").removeClass("placeholder");
    })

    $(".problem-list select[name='status']").change(function() {
        var status = this.value;
        var pid = $(this).parents("tr").find(".pid").text();
        var url = '<?php echo site_url('admin/problem/update_defunct/'); ?>'+'/'+pid;
        if(status == "available") {
            $.get(url+'/0',function(data){
                console.log(data);
            });
        }else {
             $.get(url+'/1',function(data){
                console.log(data);
            });           
        }
    });

    $(".pdel").on("click",function(c){
        c.preventDefault();
        //var line = $(this).parent().parent();
        var line = $(this).parents('tr');
        var t = $(this);
        var pid = line.find(".pid").text();
        var url = '<?php echo site_url("admin/problem/del"); ?>'+'/'+pid;
            $.getJSON(url,function(data){
                if(data.status == true ){
                    line.fadeOut();
                }else{
                    t.attr("data-content","删除失败");
                    t.popover('show');
                    setTimeout("t.popover('destroy')",1000);
                }
            });
    })
</script>

