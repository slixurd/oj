<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>课程</h3>
        </div>

        <table id="course-list" class="table">
            <thead>
                <tr>
                    <th class="span2">课程ID</th>
                    <th class="span5">课程名</th>
                    <th class="span4">课程老师</th>
                    <th class="span1">私有</th>
                </tr>
            </thead>
            <tbody class="pointer">         
                <?php foreach($list as $item): ?>
                <tr>
                    <td><?php echo $item['courseId'] ?></td>
                    <td><?php echo $item['courseName'] ?></td>
                    <td><?php echo $item['name'] ?></td>
                    <td><?php echo $item['private'] == 0?"是":"否"; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- hr class="bottom-hr" / -->

        <div class="pagination" style="text-align:center;">
          <ul>
            <?php echo $pagination_block; ?>
            <!--li class="active"><a href="">1</a></li -->
          </ul>
        </div>
    </div>
</div>
