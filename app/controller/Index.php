<?php

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
        // $infoSpaceName = Request::post('infoSpaceName');
        // if ($infoSpaceName == '生命科学馆') {
        //     $this->life();
        // } elseif ($infoSpaceName == '导师工作站') {
        //     $this->teacher();
        // } else {
        //     $this->activity();
        // }
        if (Db::table('info')->insert(Request::post())) {
            echo '预约成功';
        } else {
            echo "预约失败";
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
    public function getTicketNum()
    {
        $date = Request::post('date');
        $infoSpaceName = Request::post('infoSpaceName');
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
        $arr = ['14:00-14:30', '14:30-15:00', '15:00-15:30',];
        $num = [];
        // for ($i = 0; $i < count($arr); $i++) {
        //     //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        //     if (Db::table('lifeInfoStudentTeam')->where([
        //         'infoTime' => $arr[$i],
        //         'infoDate' => $date
        //     ])->find() ||  Db::table('lifeInfoSocialTeam')->where([
        //         'infoTime' => $arr[$i],
        //         'infoDate' => $date
        //     ])->find()) {
        //         $num[$i] = 0;
        //     } else { //否则票数为40 - 校内个人预约 - 校外个人预约
        //         $num[$i] = 40 - Db::table('lifeInfoStudent')->where([
        //             'infoTime' => $arr[$i],
        //             'infoDate' => $date
        //         ])->count() - Db::table('lifeInfoSocial')->where([
        //             'infoTime' => $arr[$i],
        //             'infoDate' => $date
        //         ])->count();
        //     }
        // }

        for ($i = 0; $i < count($arr); $i++) {
            if (Db::table('info')->where([
                'date' => $date,
                'time' => $arr[$i],
                'spaceName' => '生命科学馆'
            ])->where('num', '!=', '')->find()) {
                $num[$i] = 0;
            } else {
                $num[$i] = 40 - Db::table('info')->where([
                    'date' => $date,
                    'time' => $arr[$i],
                    'spaceName' => '生命科学馆',
                    'num' => ''
                ])->count();
            }
        }
        echo json_encode($num);
    }

    public function ticketTeacher($date)
    {
        $arr = ['08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00'];
        $num = [];
        // for ($i = 0; $i < count($arr); $i++) {
        //     //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        //     if (Db::table('teacherInfoStudentTeam')->where([
        //         'infoTime' => $arr[$i],
        //         'infoDate' => $date
        //     ])->find()) {
        //         $num[$i] = 0;
        //     } else { //否则票数为40 - 校内个人预约 - 校外个人预约
        //         $num[$i] = 20 - Db::table('teacherInfoStudent')->where([
        //             'infoTime' => $arr[$i],
        //             'infoDate' => $date
        //         ])->count();
        //     }
        // }

        for ($i = 0; $i < count($arr); $i++) {
            if (Db::table('info')->where([
                'date' => $date,
                'time' => $arr[$i],
                'spaceName' => '导师工作站'
            ])->where('num', '!=', '')->find()) {
                $num[$i] = 0;
            } else {
                $num[$i] = 40 - Db::table('info')->where([
                    'date' => $date,
                    'time' => $arr[$i],
                    'spaceName' => '导师工作站',
                    'num' => ''
                ])->count();
            }
        }
        echo json_encode($num);
    }

    public function ticketAvtivity($date)
    {
        $arr = ['08:00-09:00', '09:00-10:00', '10:00-11:00', '11:00-12:00', '12:00-13:00', '13:00-14:00', '14:00-15:00', '15:00-16:00', '16:00-17:00', '17:00-18:00', '18:00-19:00', '19:00-20:00', '20:00-21:00'];
        $num = [];
        // for ($i = 0; $i < count($arr); $i++) {
        //     //某天某个时间段如果已经被校内人员团体或者被校外人员团体提前预约，那么票数为0
        //     if (Db::table('activityInfoStudentTeam')->where([
        //         'infoTime' => $arr[$i],
        //         'infoDate' => $date
        //     ])->find()) {
        //         $num[$i] = 0;
        //     } else { //否则票数为40 - 校内个人预约 - 校外个人预约
        //         $num[$i] = 100 - Db::table('activityInfoStudent')->where([
        //             'infoTime' => $arr[$i],
        //             'infoDate' => $date
        //         ])->count();
        //     }
        // }

        for ($i = 0; $i < count($arr); $i++) {
            if (Db::table('info')->where([
                'date' => $date,
                'time' => $arr[$i],
                'spaceName' => '多功能活动室'
            ])->where('num', '!=', '')->find()) {
                $num[$i] = 0;
            } else {
                $num[$i] = 100 - Db::table('info')->where([
                    'date' => $date,
                    'time' => $arr[$i],
                    'spaceName' => '多功能活动室',
                    'num' => ''
                ])->count();
            }
        }
        echo json_encode($num);
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

    public function getInfo()
    {
        // $res1 = DB::table('activityInfoStudent')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res2 = DB::table('activityInfoStudentTeam')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res3 = DB::table('lifeInfoSocial')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res4 = DB::table('lifeInfoSocialTeam')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res5 = DB::table('lifeInfoStudent')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res6 = DB::table('lifeInfoStudentTeam')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res7 = DB::table('teacherInfoStudent')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res8 = DB::table('teacherInfoStudentTeam')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        // $res = array_merge($res1, $res2, $res3, $res4, $res5, $res6, $res7, $res8);
        // echo json_encode($res);
        $res = DB::table('info')->where('openid', Request::get('openid'))->order('id', 'desc')->select()->toArray();
        echo json_encode($res);
    }
}
