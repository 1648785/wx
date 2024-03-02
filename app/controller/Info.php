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

class GetInfo
{
    public function getInfo()
    {
        echo 'getInfo ok';
    }
    public function setInfo(){
        echo 'setInfo ok';
    }
}
