<?php echo validation_errors(); ?>

<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>修改密码</h3>
        </div>
        <form class="register"  method="post"  action="<?php echo site_url("user/modify_result"); ?>">
            <div>
                <span>*原密码</span>
                <input name="origin" type="password" required="required"/>
                <span class="reg-status">请输入原始密码</span>
            </div>
            <div>
                <span>*新密码</span>
                <input id="pa-reg" name="pa" type="password" required="required"/>
                <span class="reg-status" id="pa-status">6~20位英文,数字组成</span>
            </div>
            <div>
                <span style="font-size:14px;">*确认新密码</span>
                <input id="paconf-reg" name="paconf" type="password" required="required"/>
                <span class="reg-status" id="paconf-status">请重复输入密码</span>
            </div>
            <div>
                <span></span>
                <button style="margin-top:15px;" id="submit-reg" type="submit" class="common-button">提交修改</button>
            </div>
        </form>

    </div>
</div>
