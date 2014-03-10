<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <?php if($permission=="yes"): ?>
            <h3 style="float:right;margin-right:10px;font-size:18px;"><?php if($contest_item['private']) echo "私有"; else echo "公开"; ?></h3>
            <h3><?php echo $contest_item['title']; ?></h3>
        </div>
        <div class='ctxl'>
                <div class='s'>开始时间 - <?php echo $contest_item['startTime'] ?></div>
                <div class='e'>结束时间 - <?php echo $contest_item['endTime'] ?></div>
        </div>
        
        
        <table class="table">
            <thead>
                <tr>
                    <th class='span1'>ID</th>
                    <th class="span5">题目名称</th>
                    <th class="span2">AC总数</th>
                    <th class="span2">提交总数</th>
                    <th class="span1">来源</th>
                </tr>
            </thead>
            <tbody class="pointer">         
                <?php if(isset($is_empty)) 
                    echo "<tr><td colspan='4' class='empty-answer'>搜索结果为空</td></tr>"
                ?>  
                <?php foreach($contest_problem_list as $contest_problem): ?>
                <tr onclick="document.location='<?php echo site_url('problem/get_problem').'/'.$contest_problem['problemId'].'/1/'.$cid; ?>' ">
                    <td><?php echo $contest_problem['problemId']; ?></td>
                    <td><?php echo $contest_problem['title']; ?></td>
                    <td><?php echo $contest_problem['accepted']; ?></td>
                    <td><?php echo $contest_problem['submit']; ?></td>
                    <td><?php echo $contest_problem['source']; ?></td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                    <tr><td colspan='4' class='empty-answer'>无权限查看题目</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>




