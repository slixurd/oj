        <div class="pull-right">
        <form action="#" method="post">
            <table class="table">
                <caption>××实验\作业</caption>
                <thead>
                    <tr>
                        <th class="span2">ID</th>
                        <th class="span6">标题</th>
                        <th class="span2">编辑</th>
                        <th class="span2">删除</th>
                        <th class="span2">上移</th>
                        <th class="span1">下移</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($plist as $item) { ?>
                    <tr>
                        <td><?php echo $item['problemId'] ?></td>
                        <td><?php echo $item['title'] ?></td>
                        <td><a href="#">删除</a></td>
                        <td><a href="#">编辑</a></td>
                        <td><a href="#"><i class="Up"></i></a></td>
                        <td><a href="#"><i class="Down"></i></a></td>
                    </tr>
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
        </form>
        </div>
    </div>
</div>