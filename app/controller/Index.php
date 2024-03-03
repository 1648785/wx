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
        if (Request::post('infoAge')) { //校外人员
            if (Db::table('lifeInfoSocial')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('lifeInfoSocial')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        } else { //校内人员
            if (Db::table('lifeInfoStudent')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('lifeInfoStudent')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        }
    }

    /**
     * 查询是否有票
     */
    public function getTicketNum($date)
    {
        $num1 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->count() - Db::table('lifeInfoSocial')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->count();
        $num2 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date
        ])->count() - Db::table('lifeInfoSocial')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->count();
        $num3 = 40 - Db::table('lifeInfoStudent')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date
        ])->count() - Db::table('lifeInfoSocial')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->count();

        echo json_encode(['num1' => $num1, 'num2' => $num2, 'num3' => $num3]);
    }
}
