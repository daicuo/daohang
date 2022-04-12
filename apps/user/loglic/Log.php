<?php
namespace app\user\loglic;

class Log
{
    private $error = '';
    
    //返回错误信息
    public function getError(){
        return $this->error;
    }

    /**
     * 增加用户积分日志
     * @param array $userId 用户ID
     * @param int $logValue 增减值
     * @return int 影响条数
     */
    public function userScore($userId=0, $logValue=0, $logControll='recharge', $logAction='index', $logIp='')
    {
        $data = [];
        $data['log_name']     = 'user/'.$logControll.'/'.$logAction;
        $data['log_user_id']  = $userId;
        $data['log_info_id']  = 0;
        $data['log_value']    = $logValue;
        $data['log_module']   = 'user';
        $data['log_controll'] = $logControll;
        $data['log_action']   = $logAction;
        $data['log_type']     = 'userScore';
        $data['log_ip']       = DcEmpty($logIp,request()->ip());
        //$data['log_query']  = http_build_query(input('get.'));
        //$data['log_info']   = $this->request->header('user-agent');
        return model('common/Log','loglic')->save($data);
    }
    
}