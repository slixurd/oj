<div class="wrapper">
    <div class="container clearfix">
        <ul class="slide-bar pull-left">
            <li class="active"><a href="#">题目列表</a></li>
            <li><a href="#">添加题目</a></li>
            <li><a href="#">课程列表</a></li>
            <li><a href="#">添加课程</a></li>
            <li><a href="#">竞赛列表</a></li>
            <li><a href="#">添加竞赛</a></li>
            <li><a href="#">排名</a></li>
            <li><a href="#">状态</a></li>
            <li><a href="#">账号生成器</a></li>
            <li><a href="#">权限管理</a></li>
            <li><a href="#">修改密码</a></li>
            <li><a href="#">新手须知</a></li>
        </ul>

        <div class="problem-list pull-right">
            <table class="table">
                <caption>题目列表</caption>
                <thead>
                    <tr>
                        <th class="span1">问题ID</th>
                        <th class="span3">名称</th>
                        <th class="span2">时间</th>
                        <th class="span2">状态</th>
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
                        <td style="font-size:14px;"><?php echo $item['inDate'] ?></td>
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
                <!--li class="active"><a href="">1</a></li -->
              </ul>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
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

    $(".pdel").on("click",function(){
        var line = $(this).parent().parent();
        var pid = line.find(".pid").text();
        var url = '<?php echo site_url('admin/problem/del/'); ?>'+'/'+pid;
            $.get(url,function(data){
                line.fadeOut();
                console.log(data);
            });
    })
</script>