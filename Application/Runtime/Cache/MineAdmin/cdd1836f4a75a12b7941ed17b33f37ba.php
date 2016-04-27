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
    <table id="treeModule" title="模块列表" class="easyui-treegrid" style="width:98%;height:500px;" url="<?php echo U('Sysmodule/sysmoduleJsonData');?>" rownumbers="true" idField="id" treeField="title" toolbar="#tb">
        <thead>
            <tr>
                <th field="title" width="200" align="left">模块名称</th>
                <th field="url" width="200" align="center">链接URL</th>
                <th field="orderby" width="100" align="center">排序</th>
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
                            <td>所属父类:</td>
                            <td>
                                <select style="width:140px;" class="easyui-combobox" name="pid">
                                    <option value="0">&nbsp;</option>
                                    <?php if(is_array($pList)): $i = 0; $__LIST__ = $pList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>模块名:</td>
                            <td><input class="easyui-textbox" type="text" name="title" data-options="required:true"></input></td>
                        </tr>
                        <tr>
                            <td>URL链接:</td>
                            <td><input class="easyui-textbox" type="text" name="url" style="width:230px;"></input></td>
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
            url = "<?php echo U('Sysmodule/sysmoduleModify','',''); ?>";
            $('#ff').form('load', rows);
            $('#w').window('open');
        }
        function editrow()
        {
            var rows = $('#treeModule').datagrid('getSelected');
            if (rows) {
                url = "<?php echo U('Sysmodule/sysmoduleModify','',''); ?>?id="+rows.id;
                $('#ff').form('load', rows);
                $('#w').window('open');
            }
            else {
                $.messager.alert('提示', '请选择要修改的数据', 'info');
            }
        }
        function delrow()
        {
            var rows = $('#treeModule').datagrid('getSelected');
            if(typeof(rows.children) == "undefined"){
                var confirmMsg = "确定删除？";
            }else{
                var confirmMsg = "此分类存在下级，确定删除本分类及其下级分类？";
            }
            if (rows) {
                $.messager.confirm('提示',confirmMsg,function(r){
                    if (r){
                        $.ajax({
                            url: "<?php echo U('Sysmodule/sysmoduleDel','',''); ?>?id="+rows.id,
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