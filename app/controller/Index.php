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
    public function info()
    {
        $infoSpaceName = Request::post('infoSpaceName');
        if ($infoSpaceName == '生命科学馆') {
            $this->life();
        } elseif ($infoSpaceName == '导师工作站') {
            $this->teacher();
        } else {
            $this->activity();
        }
    }

    public function life()
    {
        if (Request::post('infoType') == '个人预约') {
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
        } else { //团体预约
            if (Request::post('infoAge')) { //校外人员
                if (Db::table('lifeInfoSocialTeam')->where(Request::post())->find()) {
                    echo '你已经预约过了';
                    die;
                }
                if (Db::table('lifeInfoSocialTeam')->insert(Request::post())) {
                    echo '预约成功';
                } else {
                    echo "预约失败";
                }
            } else { //校内人员
                if (Db::table('lifeInfoStudentTeam')->where(Request::post())->find()) {
                    echo '你已经预约过了';
                    die;
                }
                if (Db::table('lifeInfoStudentTeam')->insert(Request::post())) {
                    echo '预约成功';
                } else {
                    echo "预约失败";
                }
            }
        }
    }

    public function teacher()
    {
        if (Request::post('infoType') == '个人预约') {
            if (Db::table('teacherInfoStudent')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('teacherInfoStudent')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        } else { //团体预约
            if (Db::table('teacherInfoStudentTeam')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('teacherInfoStudentTeam')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        }
    }

    public function activity()
    {
        if (Request::post('infoType') == '个人预约') {
            if (Db::table('activityInfoStudent')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('activityInfoStudent')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        } else { //团体预约
            if (Db::table('activityInfoStudentTeam')->where(Request::post())->find()) {
                echo '你已经预约过了';
                die;
            }
            if (Db::table('activityInfoStudentTeam')->insert(Request::post())) {
                echo '预约成功';
            } else {
                echo "预约失败";
            }
        }
    }

    /**
     * 查询是否有票
     */
    public function getTicketNum($date, $infoSpaceName)
    {
        if ($infoSpaceName == '生命科学馆') {
            $this->ticketLife($date);
        } elseif ($infoSpaceName == '导师工作站') {
            $this->ticketTeacher($date);
        } else {
            $this->ticketAvtivity($date);
        }
    }

    public function ticketLife($date)
    {
        //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        if (Db::table('lifeInfoStudentTeam')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->find() ||  Db::table('lifeInfoSocialTeam')->where([
            'infoTime' => '14:00-14:30',
            'infoDate' => $date
        ])->find()) {
            $num1 = 0;
        } else { //否则票数为40 - 校内个人预约 - 校外个人预约
            $num1 = 40 - Db::table('lifeInfoStudent')->where([
                'infoTime' => '14:00-14:30',
                'infoDate' => $date
            ])->count() - Db::table('lifeInfoSocial')->where([
                'infoTime' => '14:00-14:30',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('lifeInfoStudentTeam')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date
        ])->find() ||  Db::table('lifeInfoSocialTeam')->where([
            'infoTime' => '14:30-15:00',
            'infoDate' => $date
        ])->find()) {
            $num2 = 0;
        } else {
            $num2 = 40 - Db::table('lifeInfoStudent')->where([
                'infoTime' => '14:30-15:00',
                'infoDate' => $date
            ])->count() - Db::table('lifeInfoSocial')->where([
                'infoTime' => '14:30-15:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('lifeInfoStudentTeam')->where([
            'infoTime' => '15:00-15:30',
            'infoDate' => $date
        ])->find() ||  Db::table('lifeInfoSocialTeam')->where([
            'infoTime' => '15:00-15:30',
            'infoDate' => $date
        ])->find()) {
            $num3 = 0;
        } else {
            $num3 = 40 - Db::table('lifeInfoStudent')->where([
                'infoTime' => '15:00-15:30',
                'infoDate' => $date
            ])->count() - Db::table('lifeInfoSocial')->where([
                'infoTime' => '15:00-15:30',
                'infoDate' => $date
            ])->count();
        }

        echo json_encode(['num1' => $num1, 'num2' => $num2, 'num3' => $num3]);
    }

    /**
     * 获取导师工作站票
     */
    public function ticketTeacher($date)
    {
        //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        if (Db::table('teacherInfoStudentTeam')->where([
            'infoTime' => '08:00-09:00',
            'infoDate' => $date
        ])->find()) {
            $num1 = 0;
        } else { //否则票数为40 - 校内个人预约 - 校外个人预约
            $num1 = 40 - Db::table('teacherInfoStudent')->where([
                'infoTime' => '08:00-09:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('teacherInfoStudentTeam')->where([
            'infoTime' => '09:00-10:00',
            'infoDate' => $date
        ])->find()) {
            $num2 = 0;
        } else {
            $num2 = 40 - Db::table('teacherInfoStudent')->where([
                'infoTime' => '09:00-10:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('teacherInfoStudentTeam')->where([
            'infoTime' => '10:00-11:00',
            'infoDate' => $date
        ])->find()) {
            $num3 = 0;
        } else {
            $num3 = 40 - Db::table('teacherInfoStudent')->where([
                'infoTime' => '10:00-11:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('teacherInfoStudentTeam')->where([
            'infoTime' => '11:00-12:00',
            'infoDate' => $date
        ])->find()) {
            $num4 = 0;
        } else {
            $num4 = 40 - Db::table('teacherInfoStudent')->where([
                'infoTime' => '11:00-12:00',
                'infoDate' => $date
            ])->count();
        }

        echo json_encode(['num1' => $num1, 'num2' => $num2, 'num3' => $num3, 'num4' => $num4]);
    }

    public function ticketAvtivity($date)
    {
        //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        if (Db::table('activityInfoStudentTeam')->where([
            'infoTime' => '08:00-09:00',
            'infoDate' => $date
        ])->find()) {
            $num1 = 0;
        } else { //否则票数为40 - 校内个人预约 - 校外个人预约
            $num1 = 40 - Db::table('activityInfoStudent')->where([
                'infoTime' => '08:00-09:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('activityInfoStudentTeam')->where([
            'infoTime' => '09:00-10:00',
            'infoDate' => $date
        ])->find()) {
            $num2 = 0;
        } else {
            $num2 = 40 - Db::table('activityInfoStudent')->where([
                'infoTime' => '09:00-10:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('activityInfoStudentTeam')->where([
            'infoTime' => '10:00-11:00',
            'infoDate' => $date
        ])->find()) {
            $num3 = 0;
        } else {
            $num3 = 40 - Db::table('activityInfoStudent')->where([
                'infoTime' => '10:00-11:00',
                'infoDate' => $date
            ])->count();
        }

        if (Db::table('activityInfoStudentTeam')->where([
            'infoTime' => '11:00-12:00',
            'infoDate' => $date
        ])->find()) {
            $num4 = 0;
        } else {
            $num4 = 40 - Db::table('activityInfoStudent')->where([
                'infoTime' => '11:00-12:00',
                'infoDate' => $date
            ])->count();
        }

        echo json_encode(['num1' => $num1, 'num2' => $num2, 'num3' => $num3, 'num4' => $num4]);
    }
    /**
     * 获取用户唯一标识
     */
    public function getUserID($code)
    {
        $APPID = 'wx714545d0c1221a05';
        $SECRET = 'f1aac468a405a88523acb626df767333';
        $JSCODE = $code;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/sns/jscode2session?appid=" . $APPID . "&secret=" . $SECRET . "&js_code=" . $JSCODE . "&grant_type=authorization_code");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // 将返回值保存到变量中而不直接输出
        curl_setopt($ch, CURLOPT_HEADER, false); // 不包含头部信息在返回结果中
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
}
