<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>后台管理</title>
    <link href="/Public/admin/css/default.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/themes/default/easyui.css" />
    <link rel="stylesheet" type="text/css" href="/Public/admin/js/themes/icon.css" />
    <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
    <script type="text/javascript" src="/Public/admin/js/jquery.easyui.min.js"></script>

</head>
<body>
<!-- content Start -->
    <div class="contentBox">
        <table id="tt" class="easyui-datagrid" style="width:98%;height:500px" url="<?php echo U('Sysadmin/sysadminGroupJsonData');?>" title="角色列表" data-options="singleSelect:true" rownumbers="true" toolbar="#tb">
            <thead>
                <tr>
                    <th field="title" width="200" align="center">角色名称</th>
                    <th field="orderby" width="80" align="center">排序</th>
                    <th field="formattime" width="100" align="center">创建时间</th>
                </tr>
            </thead>
        </table>
        <div id="tb">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="javascript:addrow();">新增</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="javascript:editrow();">修改</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="javascript:delrow()">删除</a>
        </div>
        <!-- 弹窗 -->
        <div id="w" class="easyui-window" title="编辑" data-options="closed:true,iconCls:'icon-save'" style="width:500px;height:400px;padding:5px;">
            <div class="easyui-layout" data-options="fit:true">
                <div data-options="region:'center'" style="padding:10px;">
                    <form id="ff" method="post">
                        <table cellpadding="5">
                            <tr>
                                <td>角色名称:</td>
                                <td><input class="easyui-textbox" type="text" name="title" data-options="required:true"></input></td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top;">权限管理:</td>
                                <td>
                                    <div class="easyui-panel" style="padding:5px">
                                        <ul id="powerList" class="easyui-tree" data-options="url:'<?php echo U('Sysadmin/sysmodulePowerJsonList');?>', animate:true, checkbox:true"></ul>
                                    </div>
                                    <input id="power" type="hidden" name="power" value="" />
                                    <script type="text/javascript">
                                        function getChecked(){
                                            var nodesP = $('#powerList').tree('getChecked','indeterminate');
                                            var nodes = $('#powerList').tree('getChecked');
                                            var s = '';
                                            for(var i=0; i<nodesP.length; i++){
                                                if (s != '') s += ',';
                                                s += nodesP[i].id;
                                            }
                                            for(var i=0; i<nodes.length; i++){
                                                if (s != '') s += ',';
                                                s += nodes[i].id;
                                            }

                                            $("#power").val(s);
                                        }
                                    </script>
                                </td>
                            </tr>
                            <tr>
                                <td>排序:</td>
                                <td><input class="easyui-textbox" type="text" name="orderby"></input></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0 0;">
                    <a id="btnEp" class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:submitForm();">确定</a>
                    <a class="easyui-linkbutton" data-options="iconCls:'icon-cancel'" href="javascript:$('#ff').form('clear');">重置</a>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            var url = '';
            function addrow()
            {
                $('#ff').form('clear');
                var addRows = '{orderby: "<?php echo $maxOrderby; ?>"}';
                rows = eval('(' + addRows + ')');
                url = "<?php echo U('Sysadmin/sysadminGroupModify','',''); ?>";
                $('#ff').form('load', rows);

                $('#powerList').tree({
                    url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>",
                });

                $('#w').window('open');
            }
            function editrow()
            {
                var rows = $('#tt').datagrid('getSelected');
                if (rows) {
                    $('#powerList').tree({
                        url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>?power="+rows.power,
                    });
                    url = "<?php echo U('Sysadmin/sysadminGroupModify','',''); ?>?id="+rows.id;
                    $('#ff').form('load', rows);
                    $('#w').window('open');
                }
                else {
                    $.messager.alert('提示', '请选择要修改的数据', 'info');
                }
            }
            function delrow()
            {
                var rows = $('#tt').datagrid('getSelected');
                if (rows) {
                    $.messager.confirm('提示',"确定删除？",function(r){
                        if (r){
                            $.ajax({
                                url: "<?php echo U('Sysadmin/sysadminGroupDel','',''); ?>?id="+rows.id,
                                dataType: "json",
                                success:function(data){
                                    if(data.status < 0){
                                        $.messager.alert('信息提示！', data.msg, 'error');
                                    }else{
                                        location.reload();
                                    }
                                }
                            });
                        }
                    });
                }
                else {
                    $.messager.alert('提示', '请选择要删除的数据', 'info');
                }
            }
            function submitForm(){
                getChecked();
                $.messager.progress();
                $('#ff').form('submit', {
                    url: url,
                    data: $(this).serialize(),
                    type: "POST",
                    dataType: "json",
                    onSubmit: function(){
                        var isValid = $(this).form('validate');
                        if (!isValid){
                            $.messager.progress('close');
                        }
                        return isValid;
                    },
                    success: function(data){
                        $.messager.progress('close');
                        var data = eval('(' + data + ')');
                        if(data.status < 0){
                            $.messager.alert('信息提示！', data.msg, 'error');
                        }else{
                            location.reload();
                        }
                    }
                });
            }

        </script>
    </div>
<!-- content End -->
</body>
</html>