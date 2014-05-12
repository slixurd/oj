    <div class="pull-right">
        <table class="table">
            <caption>课程列表</caption>
            <thead>
                <tr>
                    <th class="span1">课程ID</th>
                    <th class="span5">名称</th>
                    <th class="span3">老师</th>
                    <th class="span6">有效期</th>
                    <th class="span2">编辑</th>
                    <th class="span2">删除</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if (!empty($course_list)) {
                    foreach ($course_list as $item) { ?>
                <tr>
                    <td class='cid'><?php echo $item['courseId'] ?></td>
                    <td title="<?php echo $item['courseName'] ?>"><?php echo $item['courseName'] ?></td>
                    <td title="<?php echo $item['name'] ?>"><?php echo $item['name'] ?></td>
                    <td><?php echo $item['endTime'] ?></td>
                    <td><a href="<?php echo site_url('admin/course/unit_list/'.$item['courseId']) ?>">编辑</a></td>
                    <td><a class='del' href="">删除</a></td>
                </tr>
                <?php }}else{ ?>
                    <tr>
                        <td colspan="6">暂无内容</td>
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
</div>
</div>
<script type="text/javascript">
    $(".del").on("click",function(c){
        c.preventDefault();
        var line = $(this).parent().parent();
        var cid = line.find(".cid").text();
        var url = '<?php echo site_url("admin/course/del"); ?>'+'/'+cid;
            $.getJSON(url,function(data){
                if(data.status == true ){
                    line.fadeOut();
                }else{
                    alert(data.reason);
                }

            });
    })
</script>