
<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>登录记录</h3>
        </div>
        <table id="problem-list" class="table">
            <thead>
                <tr>
                    <th class="span6">登陆IP</th>
                    <th class="span4">登录时间</th>
                    <th class="span2">登录结果</th>
                </tr>
            </thead>
            <tbody class="pointer">         
                <?php foreach($log_list as $item): ?>
                <tr>
                    <td><?php echo $item['ip'] ?></td>
                    <td><?php echo $item['time'] ?></td>
                    <td><?php if($item['result']==1) echo "成功"; else echo "失败" ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    </div>
</div>

