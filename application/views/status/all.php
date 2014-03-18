<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>提交状态</h3>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="span2">题目ID</th>
                    <th class="span3">用户名</th>
                    <th class="span1">语言</th>
                    <th class="span1">内存</th>
                    <th class="span2">运行时间</th>
                    <th class="span3">提交时间</th>
                    <th class="span2">结果</th>
                </tr>
            </thead>
            <tbody>         
                <?php foreach($status_list as $list): ?>
                <tr>
                        <td><?php echo $list['problemId'] ?></td>
                        <td><?php echo $list['name'] ?></td>
                        <td><?php echo $lan[$list['programLan']] ?></td>
                        <td><?php echo $list['memory'] ?></td>
                        <td><?php echo $list['runTime'] ?></td>
                        <td><?php echo $list['inDate'] ?></td>
                        <td><?php echo $status[$list['result']] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="pagination" style="text-align:center;">
          <ul>
            <?php echo $pagination_block; ?>
            <!--li class="active"><a href="">1</a></li -->
          </ul>
        </div>

    </div>
</div>
