<?php
namespace MineAdmin\Model;
use Think\Model;
use Common\Model\BaseModel as BaseModel;

class SysmoduleModel extends BaseModel {

    function getList()
    {
        //一级
        $pList = $this->where("pid = 0")->order("orderby asc, createtime desc")->select();
        foreach ($pList as $key => $value) {
            $pList[$key]['formattime'] = date("Y-m-d", $value['createtime']);
            //二级
            $children = $this->where("pid = ".$value['id'])->order("orderby asc, createtime desc")->select();
            if(count($children) > 0){
                foreach ($children as $k => $val) {
                    $children[$k]['formattime'] = date("Y-m-d", $val['createtime']);
                    //三级
                    $children_ZSGC = $this->where("pid = ".$val['id'])->order("orderby asc, createtime desc")->select();
                    if(is_array($children_ZSGC) && count($children_ZSGC) > 0){
                        foreach ($children_ZSGC as $kk => $vo) {
                            $children_ZSGC[$kk]['formattime'] = date("Y-m-d", $vo['createtime']);
                        }
                        $children[$k]['children'] = $children_ZSGC;
                    }else{
                        $children[$k]['children'] = array();
                    }
                }
                $pList[$key]['children'] = $children;
            }
        }
        return $pList;
    }

    function getPowerList()
    {
        $field = array("id", "title"=>"text");
        $pList = $this->field($field)->where("pid = 0")->order("orderby asc, createtime desc")->select();
        foreach ($pList as $key => $value) {
            $children = $this->field($field)->where("pid = ".$value['id'])->order("orderby asc, createtime desc")->select();
            if(count($children) > 0){
                $pList[$key]['children'] = $children;
            }
        }
        return $pList;
    }

    function getPidList()
    {
        $pList = $this->where("pid = 0")->order("orderby asc, createtime desc")->select();
        foreach ($pList as $key => $value) {
            $pList[$key]['formattime'] = date("Y-m-d", $value['createtime']);
            //二级
            $children = $this->where("pid = ".$value['id'])->order("orderby asc, createtime desc")->select();
            if(is_array($children) && count($children) > 0){
                foreach ($children as $k => $val) {
                    $children[$k]['formattime'] = date("Y-m-d", $val['createtime']);
                }
                $pList[$key]['children'] = $children;
            }else{
                $pList[$key]['children'] = array();
            }
        }
        return $pList;
    }

    function delRow($id)
    {
        //判断下级分类
        $arrId = $this->where("pid=$id")->getField('id', true);
        if(is_array($arrId) && count($arrId) > 0){
            $arrId[] = $id;
            $map['id'] = array("in", $arrId);
            $rs = $this->where($map)->delete();
        }else{
            $rs = $this->where("id=$id")->delete();
        }
        return $rs;
    }

}
