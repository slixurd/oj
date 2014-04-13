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