<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="zh-cn">
<head>
        <title><?php if(isset($page_title)) echo $page_title ?></title>
        <meta http-equiv="Content-Type" content="text/html" charset="utf-8"/>
        <meta name="description" content=""/>
        <meta name="author" content="slixurd"/>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url("assets") ?>/css/admin.css">
        <link rel="icon" type="image/vnd.microsoft.icon" href="favicon.ico">
        <link rel="icon" href="favicon.ico" type="image/x-icon" />
        <script src="<?php echo base_url("assets") ?>/js/jquery-1.9.1.js"></script>
        <script type="text/javascript" src="<?php echo base_url("assets") ?>/js/main.js"></script>
        <script type="text/javascript" src="<?php echo base_url("assets") ?>/js/admin.js"></script>
        <script type="text/javascript" src="<?php echo base_url("assets") ?>/js/bootstrap.js"></script>

</head>
<body>
<div class="header">
        <div class="container" style="height:54px;">

                <div class="i-c">
                        <div class="main-nav clearfix">
                                <span style="float:left;margin-top: 8px;display:inline-block;width:66px;"><img src="<?php echo base_url("assets") ?>/img/logo.png"></span>
                        </div>
                </div>
                <div class="panel">
                        <a href='<?php echo site_url("user") ?>' class="admin-name">
                                <?php echo $user["name"] ?>
                        </a>
                        <a href="<?php echo site_url("welcome") ?>" class="return">返回主页</a>

                </div>
        </div>
</div>

<div class="wrapper">
    <div class="container clearfix">
        <ul class="slide-bar pull-left">
            <!-- class="active" -->
            <li><a href="<?php echo site_url('admin/problem') ?>">题目列表</a></li>
            <li><a href="<?php echo site_url('admin/problem/add') ?>">添加题目</a></li>
            <li><a href="<?php echo site_url('admin/course') ?>">课程列表</a></li>
            <li><a href="<?php echo site_url('admin/course/add') ?>">添加课程</a></li>
            <li><a href="#">竞赛列表</a></li>
            <li><a href="#">添加竞赛</a></li>
            <li><a href="#">排名</a></li>
            <li><a href="#">状态</a></li>
            <li><a href="#">账号生成器</a></li>
            <li><a href="#">权限管理</a></li>
            <li><a href="#">修改密码</a></li>
            <li><a href="#">新手须知</a></li>
        </ul>