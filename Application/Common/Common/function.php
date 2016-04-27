<?php

/**
 * json 输出
 * 成功时传一个参数：结果集
 * 失败时传入两个参数，1是错误码，2是错误信息
 */
function response()
{
    if(func_num_args()==1){
        echo json_encode(array('errno'=>0, 'data'=>func_get_arg(0)));
    }else if(func_num_args()==2){
        echo json_encode(array('errno'=>func_get_arg(0), 'msg'=>func_get_arg(1)));
    }else{

    }
    exit;
}
