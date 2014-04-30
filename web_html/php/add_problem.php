
    <div class="add-problem pull-right">
    <form class="add-problem-form" action="<?php echo site_url('admin/problem/add_problem') ?>" method="post">
        <div>
            <h3>添加题目</h3>
            <div class="row">
                <span class="tip">题目：</span>
                <input class="necessary" id="title" type="text" name="title" />
            </div>
            <div class="row">
                <span class="tip">题目来源：</span>
                <input id="source" type="text" name="source" />
            </div>
            <div class="row">
                <div class="append">
                    <span class="tip">时间限制：</span>
                    <input class="necessary" id="time-limit" type="text" name="time-limit" />
                    <span class="add-on">ms</span>
                </div>
                <div class="append text-right">
                    <span class="tip">内存限制：</span>
                    <input class="necessary" id="memory-limit" type="text" name="memory-limit" />
                    <span class="add-on">byte</span>
                </div>
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
                <div class="tab-pane" id="tab12"><textarea class="necessary" name="input"></textarea></div>
                <div class="tab-pane" id="tab13"><textarea class="necessary" name="output"></textarea></div>
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
                        <textarea class="necessary" name="input-test"></textarea>
                        <span>测试输出：</span>
                        <textarea class="necessary" name="output-test"></textarea>
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
<!--
    哪一个输入不能为空，则只需为其添加'necessary'类
-->
<script type="text/javascript">
//使选项卡可用
    load_tab();

//表单验证
    $('form').bind('submit', function(event) {
        if(!check_ness() | !check_num()) {
            return false;
        }
    });

//输入时提示框自动消失
    $('input[type="text"],textarea').bind('keydown', function(event) {
        if(event.shiftKey) {
            $(this).next('i.popTip').fadeOut('slow', function() {
                $(this).next('i.popTip').remove();
            });
            return;
        }
        var charCode = event.keyCode;
        if(charCode == 32 || 
            (charCode >= 48 && charCode <= 57) || 
            (charCode >= 65 && charCode <= 90) || 
            (charCode >= 97 && charCode <= 122)){
            $(this).next('i.popTip').fadeOut('slow', function() {
                $(this).next('i.popTip').remove();
            });
        }

        var id = $(this).parents('.tab-pane')[0].id;
        var nav_tab = $('a[rel="#' + id + '"]').parent();
        $(nav_tab[0]).next('i.popTip').fadeOut('slow', function() {
            $(nav_tab[0]).next('i.popTip').remove();
        });
    });
</script>