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
        <table id="tt" class="easyui-datagrid" style="width:98%;height:500px" url="<?php echo U('Sysadmin/sysadminJsonData');?>" title="管理员列表" data-options="singleSelect:true" rownumbers="true" toolbar="#tb">
            <thead>
                <tr>
                    <th field="username" width="200" align="center">管理员名称</th>
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
                                <td>管理员名称:</td>
                                <td><input class="easyui-textbox" type="text" name="username" data-options="required:true"></input></td>
                            </tr>
                            <tr>
                                <td>密码:</td>
                                <td><input class="easyui-textbox" type="password" name="password"></input><span class="red">不修改则留空！</span></td>
                            </tr>
                            <tr>
                                <!-- TODO: BUG 选择角色后改变权限再保存，修改查看时不是显示之前保存的选择权限，而是当前选择的角色权限！ -->
                                <td>所属角色:</td>
                                <td>
                                    <select id="sysadminGroup" style="width:140px;" class="easyui-combobox" name="pid">
                                        <option value="0">&nbsp;</option>
                                        <?php if(is_array($sysadminGroupList)): $i = 0; $__LIST__ = $sysadminGroupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                    </select>
                                </td>
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
                selectPid();
                $('#ff').form('clear');
                var addRows = '{orderby: "<?php echo $maxOrderby; ?>"}';
                rows = eval('(' + addRows + ')');
                url = "<?php echo U('Sysadmin/sysadminModify','',''); ?>";
                $('#ff').form('load', rows);
                $('#powerList').tree({
                    url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>",
                });
                $('#w').window('open');
            }
            function editrow()
            {
                selectPid();
                var rows = $('#tt').datagrid('getSelected');
                if (rows) {
                    $('#powerList').tree({
                        url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>?power="+rows.power,
                    });
                    url = "<?php echo U('Sysadmin/sysadminModify','',''); ?>?id="+rows.id;
                    //js去掉密码对象
                    delete rows.password;
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
                                url: "<?php echo U('Sysadmin/sysadminDel','',''); ?>?id="+rows.id,
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
            function selectPid(){
                $("#sysadminGroup").combobox({
                    onChange: function(n, o){
                        if(n == 0){
                            $('#powerList').tree({
                                url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>",
                            });
                            $.messager.alert('提示', '角色为空，请重新选择权限！', 'info');
                        }else{
                            $.ajax({
                                url: "<?php echo U('Sysadmin/groupIdForPower','',''); ?>?id="+n,
                                dataType: "json",
                                success:function(data){
                                    $('#powerList').tree({
                                        url: "<?php echo U('Sysadmin/sysmodulePowerJsonList','',''); ?>?power="+data,
                                    });
                                }
                            });
                        }
                    }
                });
            }

        </script>
    </div>
<!-- content End -->
</body>
</html>