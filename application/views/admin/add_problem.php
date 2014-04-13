<div class="wrapper">
<div class="container clearfix">
    <ul class="slide-bar pull-left">
        <li><a href="#">题目列表</a></li>
        <li class="active"><a href="#">添加题目</a></li>
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

    <div class="add-problem pull-right">
    <form class="add-problem-form" action="#" method="post">
        <div>
            <h3>添加题目</h3>
            <div class="row">
                <span>题目：</span>
                <input type="text" name="title" />
            </div>
            <div class="row">
                <span>时间限制：</span>
                <input type="text" name="time-limit" placeholder="秒" />
                <span class="text-center">内存限制：</span>
                <input type="text" name="memory-limit" placeholder="MByte" />
            </div>
        </div>
        <div>
            <ul class="nav-tabs">
                <li class="active"><a rel="#tab11">描述</a></li>
                <li><a rel="#tab12">输入</a></li>
                <li><a rel="#tab13">输出</a></li>
                <li><a rel="#tab14">提示</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab11"><textarea name="description"></textarea></div>
                <div class="tab-pane" id="tab12"><textarea name="input"></textarea></div>
                <div class="tab-pane" id="tab13"><textarea name="output"></textarea></div>
                <div class="tab-pane" id="tab14"><textarea name="hint"></textarea></div>
            </div>
        </div>
        <div class="vertical-middle">
            <ul class="nav-tabs">
                <li class="active"><a rel="#tab21">样例</a></li>
                <li><a rel="#tab22">测试</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab21">
                    <div class="row">
                        <span>输入样例：</span>
                        <textarea name="sampleInput"></textarea>
                        <span>输出样例：</span>
                        <textarea name="sampleOutput"></textarea>
                    </div>
                </div>
                <div class="tab-pane" id="tab22">
                    <div class="row">
                        <span>测试输入：</span>
                        <textarea name="input-test"></textarea>
                        <span>测试输出：</span>
                        <textarea name="output-test"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="submit-footer">
            <input type="submit" class="btn" value="确定" />
        </div>
    </form>
    </div>
</div>
</div>