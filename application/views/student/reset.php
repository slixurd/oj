<div class="wrapper">
    <div class="container">
        <div class="sub-header">
            <h3>重置密码</h3>
        </div>
        <form class="register"  method="post"  action="<?php echo site_url("user/reset_result"); ?>">
            <div>
                <span>*用户名</span>
                <input name="name" type="text" required="required"/>
                <span class="reg-status">请输入用户名</span>
            </div>
            <div>
                <span>*邮箱</span>
                <input name="email" type="email" required="required"/>
                <span class="reg-status" id="pa-status">请输入注册时使用的邮箱</span>
            </div>
             <div>
                <span>*新密码</span>
                <input name="pass" type="password" required="required"/>
                <span class="reg-status" id="pa-status">输入新密码</span>
            </div>
            <div>
                <span></span>
                <button style="margin-top:15px;" id="submit-reg" type="submit" class="common-button">提交修改</button>
            </div>
        </form>

    </div>
</div>
