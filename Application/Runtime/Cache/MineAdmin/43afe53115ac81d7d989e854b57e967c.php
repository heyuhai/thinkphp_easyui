<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/themes/icon.css" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/admin/js/jquery.easyui.min.js"></script>
</head>
<body>
<!-- content Start -->
<div class="">
    <table id="treeModule" title="模块列表" class="easyui-treegrid" style="width:100%;height:450px;" url="data/treegrid_data.json" rownumbers="true" idField="id" treeField="name">
        <thead>
            <tr>
                <th field="id" width="50">ID</th>
                <th field="title" width="200" align="center">模块名称</th>
                <th field="orderby" width="100" align="center">排序</th>
                <th field="actionOP" width="150" align="center">操作</th>
            </tr>
        </thead>
    </table>
</div>
<!-- content End -->
</body>
</html>