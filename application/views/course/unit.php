<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>单元题集</h3>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="span2">题目ID</th>
                    <th class="span5">标题</th>
                    <th class="span4">AC</th>
                    <th class="span1">提交</th>
                </tr>
            </thead>
            <tbody>         
                <tr onclick="document.location='<?php echo site_url('problem/unit').'/'.$unit['courseId'].'/'.$unit['unitId']; ?>' ">
                    <?php foreach($list as $item): ?>
                    <td><?php echo $item['problemId'] ?></td>
                    <td><?php echo $item['title'] ?></td>
                    <td><?php echo $item['accepted'] ?></td>
                    <td><?php echo $item['submit'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>
