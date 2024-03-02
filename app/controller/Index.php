<?php
// +----------------------------------------------------------------------
// | 文件: index.php
// +----------------------------------------------------------------------
// | 功能: 提供todo api接口
// +----------------------------------------------------------------------
// | 时间: 2021-11-15 16:20
// +----------------------------------------------------------------------
// | 作者: rangangwei<gangweiran@tencent.com>
// +----------------------------------------------------------------------

namespace app\controller;

use think\facade\Request;
use think\facade\Db;

class Index
{

    /**
     * 生命科学馆 本校人员提交预约信息
     */
    public function lifeInfoStudent()
    {
        // $data['infoUname'] = Request::param('infoUname');
        // echo Request::param('infoActivity');
        // echo Request::param('infoClass');
        // echo Request::param('infoCode');
        // echo Request::param('infoPhone');
        // echo Request::param('infoType');
        // if (Request::param('infoTime') == "1") {
        //     echo "14:30-15:00";
        // } elseif (Request::param('infoTime') == "2") {
        //     echo "15:30-16:00";
        // } else {
        //     echo "16:30-17:00";
        // }
        // echo Request::param('infoTime');

        // echo Request::param('infoDate')['date'];
        // echo Request::param('infoDate')['dayOfWeek'];
        if(Db::table('lifeInfoStudent')->insert(Request::param())){
            echo '预约成功';
        }else{
            echo "预约失败";
        }
    }

    /**
     * 查询是否有票
     */
    public function getTicketNum($date)
    {
        echo "日期：" . $date['date'];
        echo "星期：" . $date['dayOfWeek'];
    }
}
