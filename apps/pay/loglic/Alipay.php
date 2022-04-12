<?php
namespace app\pay\loglic;

//即时到账交易接口

class Alipay 
{
    protected $charset = 'utf-8';
    
    //APPID
    protected $appId;
    
    //私钥值
    protected $rsaPrivateKey;
    
    //支付宝公钥
    protected $alipayPublicKey;
    
    /**
     * 定义支付宝后台支付配置相关字段
     * @version 1.0.0 首次引入
     * @param array $post 必需;数组格式（通常为表单提交的POST）;默认：空
     * @return mixed 成功时返回obj,失败时null
     */
    public function fields($data=[])
    {
        return [
            'status' => [
                'type'        => 'radio', 
                'value'       => DcEmpty($data['status'],'hidden'),
                'option'      => ['normal'=>'正常','hidden'=>'暂停'],
                'title'       => '支付状态',
                'class_right_check' => 'form-check form-check-inline py-1',
            ],
            'app_id' => [
                'type'        => 'text', 
                'value'       => $data['app_id'],
                'title'       => 'APPID',
                'placeholder' => '',
                'tips'        => '支付宝开放平台>帐户中心>开放平台密钥',
            ],
            'private_key' => [
                'type'        => 'textarea', 
                'value'       => $data['private_key'],
                'rows'        => 16,
                'title'       => '商户私钥',
                'placeholder' => '',
                'tips'        => '<a href="https://opendocs.alipay.com/mini/02c7i5" target="_blank">商户私钥生成方法</a>',
            ],
            'alipay_public_key' => [
                'type'        => 'textarea', 
                'value'       => $data['alipay_public_key'],
                'rows'        => 5,
                'title'       => '支付宝公钥',
                'placeholder' => '',
                'tips'        => '<a href="https://open.alipay.com/dev/workspace/key-manage" target="_blank">支付宝公钥设置与查看</a>',
            ],
        ];
    }
    
    /**
     * 生成PC端支付链接
     * @version 1.0.0 首次引入
     * @param array $post 必需;订单参数 {
     *     @type string $notify_url 必需;异步通知接口;默认：空
     *     @type string $return_url 必需;同步通知接口;默认：空
     *     @type string $pay_name 必需;订单标题;默认：空
     *     @type string $pay_sign 必需;订单号;默认：空
     *     @type string $pay_total_fee 必需;订单金额（2位小数）;默认：空
     * }
     * @return string html表单代码
     */
    public function create($post=[])
    {
        //获取配置信息
        $this->config();
        
        //请求参数
        $requestConfigs = array(
            'out_trade_no' => $post['pay_sign'],//系统订单号
            'product_code' => 'FAST_INSTANT_TRADE_PAY',
            'total_amount' => sprintf("%.2f",$post['pay_total_fee']), //总费用单位元
            'subject'      => $post['pay_name'],  //订单标题
        );
        $commonConfigs = array(
            //公共参数
            'app_id'     => $this->appId,
            'method'     => 'alipay.trade.page.pay',             //接口名称
            'format'     => 'JSON',
            'return_url' => $post['return_url'],                 //同步通知
            'charset'    => $this->charset,
            'sign_type'  => 'RSA2',
            'timestamp'  => date('Y-m-d H:i:s'),
            'version'    => '1.0',
            'notify_url' => $post['notify_url'],                 //异步通知
            'biz_content'=>json_encode($requestConfigs),
        );
        //生成签名
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        //生成付款链接
        return $this->buildRequestForm($commonConfigs);
	}
    
     /**
     * 生成WAP端支付链接 https://opendocs.alipay.com/open/203/105288
     * @version 1.0.0 首次引入
     * @param array $post 必需;订单参数 {
     *     @type string $notify_url 必需;异步通知接口;默认：空
     *     @type string $return_url 必需;同步通知接口;默认：空
     *     @type string $pay_name 必需;订单标题;默认：空
     *     @type string $pay_sign 必需;订单号;默认：空
     *     @type string $pay_total_fee 必需;订单金额（2位小数）;默认：空
     * }
     * @return string html表单代码
     */
    public function createWap($post=[])
    {
        //获取配置信息
        $this->config();
        
        //请求参数
        $requestConfigs = array(
            'out_trade_no' => $post['pay_sign'],//系统订单号
            'product_code' => 'QUICK_WAP_WAY',//网关
            'total_amount' => sprintf("%.2f",$post['pay_total_fee']), //总费用单位元
            'subject'      => $post['pay_name'],  //订单标题
        );
        $commonConfigs = array(
            //公共参数
            'app_id'     => $this->appId,
            'method'     => 'alipay.trade.wap.pay',              //接口名称
            'format'     => 'JSON',
            'return_url' => $post['return_url'],                 //同步通知
            'charset'    => $this->charset,
            'sign_type'  => 'RSA2',
            'timestamp'  => date('Y-m-d H:i:s'),
            'version'    => '1.0',
            'notify_url' => $post['notify_url'],                 //异步通知
            'biz_content'=>json_encode($requestConfigs),
        );
        //生成签名
        $commonConfigs["sign"] = $this->generateSign($commonConfigs, $commonConfigs['sign_type']);
        //生成付款链接
        return $this->buildRequestForm($commonConfigs);
    }
    
    //异步回调通知处理接口
    //https://opendocs.alipay.com/open/270/105902
    public function notify($post=[])
    {
        //获取配置信息
        $this->config();
		//验证是否合法请求
		$isSign = $this->rsaCheck($post, $post["sign_type"]);
        //验证失败
        if(!$isSign) {
            return "error";
        }
		//查询系统订单信息
        $payInfo = model('pay/Common','loglic')->get([
            'cache' => false,
            'with'  => '',
            'where' => ['pay_sign'=>['eq',$post['out_trade_no']]],
        ]);
        //验证交易状态
        if ($post['trade_status'] == 'TRADE_SUCCESS') {
            //交易成功且金额相同时回调应用的支付成功处理接口
            if($payInfo['pay_module'] && $post['total_amount'] == $payInfo['pay_total_fee']){
                $payInfo['pay_number'] = $post['trade_no'];//支付宝交易号
                model($payInfo['pay_module'].'/Pay','loglic')->success($post, $payInfo);
            }
        }else{
            //交易失败时回调应用的支付失败处理接口
            if($payInfo['pay_module']){
                model($payInfo['pay_module'].'/Pay','loglic')->fail($post, $payInfo);
            }
        }
        //返回支付宝格式
        return "success";
	}

    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @return 提交表单HTML文本
     */
    private function buildRequestForm($para_temp) {

        $sHtml = "正在跳转至支付页面...<form id='alipaysubmit' name='alipaysubmit' action='https://openapi.alipay.com/gateway.do?charset=".$this->charset."' method='POST'>";
		foreach($para_temp as $key=>$val){
            if (false === $this->checkEmpty($val)) {
                $val = str_replace("'","&apos;",$val);
                $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
            }	
		}
        //submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='ok' style='display:none;'></form>";
        $sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
        return $sHtml;
    }

    private function generateSign($params, $signType = "RSA") {
        return $this->sign($this->getSignContent($params), $signType);
    }

    private function sign($data, $signType = "RSA") {
        $priKey=$this->rsaPrivateKey;
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or die('您使用的私钥格式错误，请检查RSA私钥配置');
        if ("RSA2" == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256); 
            //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 校验$value是否非空
     *  if not set ,return true;
     *    if is null , return true;
     **/
    private function checkEmpty($value) {
        if (!isset($value))
            return true;
        if ($value === null)
            return true;
        if (trim($value) === "")
            return true;

        return false;
    }

    private function getSignContent($params) {
        ksort($params);
        $stringToBeSigned = "";
        $i = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && "@" != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);
                if ($i == 0) {
                    $stringToBeSigned .= "$k" . "=" . "$v";
                } else {
                    $stringToBeSigned .= "&" . "$k" . "=" . "$v";
                }
                $i++;
            }
        }

        unset ($k, $v);
        return $stringToBeSigned;
    }

    /**
     * 转换字符集编码
     * @param $data
     * @param $targetCharset
     * @return string
     */
    private function characet($data, $targetCharset) {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (strcasecmp($fileType, $targetCharset) != 0) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }
        return $data;
    }
    
    /**
     *  验证签名
     **/
    private function rsaCheck($params) {
        $sign = $params['sign'];
        $signType = $params['sign_type'];
        unset($params['sign_type']);
        unset($params['sign']);
        return $this->verify($this->getSignContent($params), $sign, $signType);
    }
    private function verify($data, $sign, $signType = 'RSA') {
        $pubKey= $this->alipayPublicKey;
        $res = "-----BEGIN PUBLIC KEY-----\n" .
            wordwrap($pubKey, 64, "\n", true) .
            "\n-----END PUBLIC KEY-----";
        ($res) or die('支付宝RSA公钥错误。请检查公钥文件格式是否正确');

        //调用openssl内置方法验签，返回bool值
        if ("RSA2" == $signType) {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res, version_compare(PHP_VERSION,'5.4.0', '<') ? SHA256 : OPENSSL_ALGO_SHA256);
        } else {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }
        return $result;
    }
    
    //获取支付宝配置
    private function config()
    {
        $config = payConfig(['cache'=>true, 'controll'=>'alipay']);
        if($config['status'] == 'normal'){
            $this->appId             = $config['app_id'];
            $this->rsaPrivateKey     = $config['private_key'];
            $this->alipayPublicKey   = $config['alipay_public_key'];
            return $config;
        }
        return false;
    }
}
?>