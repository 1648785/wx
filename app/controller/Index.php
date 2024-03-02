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
        if (Db::table('lifeInfoStudent')->insert(Request::post())) {
            echo '预约成功';
        } else {
            echo "预约失败";
        }
    }

    /**
     * 查询是否有票
     */
    public function getTicketNum($date)
    {
        $num1 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date['date'] . ',' . $date['dayOfWeek']
        ])->count();
        $num2 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date['date'] . ',' . $date['dayOfWeek']
        ])->count();
        $num3 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date['date'] . ',' . $date['dayOfWeek']
        ])->count();

        echo 'num1='.$num1.'num2='.$num2.'num3='.$num3;
    }
}
