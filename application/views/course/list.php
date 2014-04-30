<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>单元</h3>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="span2">单元ID</th>
                    <th class="span4">单元名称</th>
                    <th class="span3">开始时间</th>
                    <th class="span3">结束时间</th>
                </tr>
            </thead>
            <tbody>         
                <?php foreach($units as $unit): ?>
                <tr onclick="document.location='<?php echo site_url('course/unit').'/'.$unit['courseId'].'/'.$unit['unitId']; ?>' ">
                        <td><?php echo $unit['unitId'] ?></td>
                        <td><?php echo $unit['title'] ?></td>
                        <td><?php echo $unit['startTime'] ?></td>
                        <td><?php echo $unit['endTime'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- hr class="bottom-hr" / -->


    </div>
</div>
