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

use Error;
use Exception;
use app\model\Counters;
use think\response\Html;
use think\response\Json;
use think\facade\Log;
use think\facade\Request;

class Index
{

    /**
     * 主页静态页面
     * @return Html
     */
    public function index(): Html
    {
        # html路径: ../view/index.html
        return response(file_get_contents(dirname(dirname(__FILE__)).'/view/index.html'));
    }


    /**
     * 获取todo list
     * @return Json
     */
    public function getCount(): Json
    {
        try {
            $data = (new Counters)->find(1);
            if ($data == null) {
                $count = 0;
            }else {
                $count = $data["count"];
            }
            $res = [
                "code" => 0,
                "data" =>  $count
            ];
            Log::write('getCount rsp: '.json_encode($res));
            return json($res);
        } catch (Error $e) {
            $res = [
                "code" => -1,
                "data" => [],
                "errorMsg" => ("查询计数异常" . $e->getMessage())
            ];
            Log::write('getCount rsp: '.json_encode($res));
            return json($res);
        }
    }


    /**
     * 根据id查询todo数据
     * @param $action `string` 类型，枚举值，等于 `"inc"` 时，表示计数加一；等于 `"reset"` 时，表示计数重置（清零）
     * @return Json
     */
    public function updateCount()
    {
        echo Request::param('infoUname');
        echo Request::param('infoActivity');
        echo Request::param('infoClass');
        echo Request::param('infoCode');
        echo Request::param('infoPhone');
        echo Request::param('infoType');
        if(Request::param('infoTime') == "1"){
            echo "14:30-15:00";
        }elseif(Request::param('infoTime') == "2"){
            echo "15:30-16:00";
        }else{
            echo "16:30-17:00";
        }
        echo Request::param('infoTime');

        echo Request::param('infoDate')['date'];
        echo Request::param('infoDate')['dayOfWeek'];


    }
    /**
     * 查询是否有票
     */

    public function getTicketNum($date,$time){
        echo "日期：".$date['date'];
        echo "星期：".$date['dayOfWeek'];
        echo "时间段".$time;
    }
}
