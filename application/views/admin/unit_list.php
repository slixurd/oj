    <div class="add-tab pull-right">
        <table class="table">
            <caption>课程列表</caption>
            <thead>
                <tr>
                    <th class="span1">课程ID</th>
                    <th class="span7">名称</th>
                    <th class="span6">开始时间</th>
                    <th class="span6">结束时间</th>
                    <th class="span2">编辑</th>
                    <th class="span2">删除</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plist as $item) { ?>
                <tr>
                    <td><?php echo $item['unitId'] ?></td>
                    <td><?php echo $item['title'] ?></td>
                    <td><?php echo $item['startTime'] ?></td>
                    <td><?php echo $item['endTime'] ?></td>
                    <td><a href="#">编辑</a></td>
                    <td><a href="#">删除</a></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>

        <div>
        <form action="#" method="post">
            <h3>新建实验\作业</h3>
            <div class="row1">
                <span class="tip">名称：</span>
                <input type="text" name="title" />
            </div>
            <div class="row2">
                <span class="tip">开始时间：</span>
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" name="start_year">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" name="start_mon">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" name="start_date">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span hour placeholder">时<i class="down"></i></span>
                    <select class="select-down-select hour" autocomplete="off" name="start_hour">
                    </select>
                </div>
                <div class="select-down last-child">
                    <span class="select-down-span minute placeholder">分<i class="down"></i></span>
                    <select class="select-down-select minute" autocomplete="off" name="start_min">
                    </select>
                </div>
            </div>
            <div class="row3">
                <span class="tip">结束时间：</span>
                <div class="select-down">
                    <span class="select-down-span year placeholder">年<i class="down"></i></span>
                    <select class="select-down-select year" autocomplete="off" name="end_year">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span month placeholder">月<i class="down"></i></span>
                    <select class="select-down-select month" autocomplete="off" name="end_mon">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span date placeholder">日<i class="down"></i></span>
                    <select class="select-down-select date" autocomplete="off" name="end_date">
                    </select>
                </div>
                <div class="select-down">
                    <span class="select-down-span hour placeholder">时<i class="down"></i></span>
                    <select class="select-down-select hour" autocomplete="off" name="end_hour">
                    </select>
                </div>
                <div class="select-down last-child"> 
                    <span class="select-down-span minute placeholder">分<i class="down"></i></span>
                    <select class="select-down-select minute" autocomplete="off" name="end_min">
                    </select>
                </div>
            </div>
            <hr />
            <div class="row6">
                <span class="tip">名单：</span>
                <textarea name="list"></textarea>
            </div>
            <hr />
            <div class="row7">
                <span class="tip">描述：</span>
                <textarea name="describe"></textarea>
            </div>
            <div class="submit-footer">
                <input type="submit" class="btn" value="添加题目" />
            </div>
        </form>
        </div>
    </div>
</div>
</div>