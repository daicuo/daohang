<?php
namespace app\pay\loglic;

//即时到账交易接口

class Alipayold
{
    protected $partner           = 'xxx';//支付宝商家ID
    
    protected $private_key       = 'xxx';//商户私钥
    
    protected $alipay_public_key ='xxx';//支付宝公钥
    
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
            'partner' => [
                'type'        => 'text', 
                'value'       => $data['partner'],
                'title'       => '合作伙伴身份',
                'placeholder' => '2008开头的一串字符串',
                'tips'        => '支付宝开放平台>帐号中心>Mapi网关产品密钥',
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
                'tips'        => '<a href="https://b.alipay.com/order/pidAndKey.htm" target="_blank">支付宝公钥查看地址</a>',
            ],
        ];
    }
    
    /**
     * 生成支付链接
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
        //拼装请求参数
		$data = array();
        $data['_input_charset'] = 'utf-8';
		$data['service']        = 'create_direct_pay_by_user';//使用即时到帐交易接口
		$data['payment_type']   = '1';//默认值为：1（商品购买）
		$data['quantity']       = '1';//数量
        $data['subject']        = $post['pay_name'];
		$data['partner']        = $this->partner;
        $data['seller_id']      = $this->partner;
		$data['out_trade_no']   = $post['pay_sign'];//uniqid()
		$data['notify_url']     = $post['notify_url'];//异步通知
		$data['return_url']     = $post['return_url'];//同步通知
		$data['total_fee']      = sprintf("%.2f",$post['pay_total_fee']);//总费用
		return $this->buildRequestForm($data);
	}
    
    /**
     * 生成wap端支付链接
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
        //拼装请求参数
		$data = array();
        $data['_input_charset'] = 'utf-8';
		$data['service']        = 'alipay.wap.create.direct.pay.by.user';//使用即时到帐交易接口
		$data['payment_type']   = '1';//默认值为：1（商品购买）
		$data['quantity']       = '1';//数量
        $data['subject']        = $post['pay_name'];
		$data['partner']        = $this->partner;
        $data['seller_id']      = $this->partner;
		$data['out_trade_no']   = $post['pay_sign'];//uniqid()
		$data['notify_url']     = $post['notify_url'];//异步通知
		$data['return_url']     = $post['return_url'];//同步通知
		$data['total_fee']      = sprintf("%.2f",$post['pay_total_fee']);//总费用
		return $this->buildRequestForm($data);
	}
    
    //异步回调通知处理接口
    //https://opendocs.alipay.com/open/62/104743
    //TRADE_SUCCESS TRADE_FINISHED
    //$post['out_trade_no'] $post['total_fee'] $post['seller_id']
    public function notify($post=[])
    {
        //获取配置信息
        $this->config();
        //验证是否合法请求
		$isSign = $this->getSignVeryfy($post, $post["sign"]);
        //验证失败
        if(!$isSign) {
            return "fail";
        }
		//查询系统订单信息
        $payInfo = model('pay/Common','loglic')->get([
            'cache' => false,
            //'field' => 'pay_id,pay_sign,pay_total_fee,pay_status,pay_user_id',
            'with'  => '',
            'where' => ['pay_sign'=>['eq',$post['out_trade_no']]],
        ]);
        //验证交易状态
        if ($post['trade_status'] == 'TRADE_SUCCESS') {
            //交易成功且金额相同时回调应用的支付成功处理接口
            if($payInfo['pay_module'] && $post['total_fee'] == $payInfo['pay_total_fee']){
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
	 * @param $method 提交方式。两个值可选：post、get
	 * @param $button_name 确认按钮显示文字
	 * @return 提交表单HTML文本
	 */
	private function buildRequestForm($para_temp, $method='POST', $button_name='点击支付') {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp);
		$sHtml = "<form id='alipaysubmit' name='alipaysubmit' action='https://mapi.alipay.com/gateway.do?_input_charset=utf-8' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
			$sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
		}
		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."' style='display:none;'></form>";
		$sHtml = $sHtml."<script>document.forms['alipaysubmit'].submit();</script>";
		return $sHtml;
	}
	
	/**
	 * 生成要请求给支付宝的参数数组
	 * @param $para_temp 请求前的参数数组
	 * @return 要请求的参数数组
	 */
	private function buildRequestPara($para_temp) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort);
		
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		$para_sort['sign_type'] = 'RSA';
		
		return $para_sort;
	}
	
	/**
	 * 除去数组中的空值和签名参数
	 * @param $para 签名参数组
	 * return 去掉空值与签名参数后的新签名参数组
	 */
	private function paraFilter($para) {
		$para_filter = array();
		while (list ($key, $val) = each ($para)) {
			if($key == "sign" || $key == "sign_type" || $val == "")continue;
			else	$para_filter[$key] = $para[$key];
		}
		return $para_filter;
	}
	
	/**
     * 对数组排序
     * @param $para 排序前的数组
     * return 排序后的数组
     */
	private function argSort($para) {
		ksort($para);
		reset($para);
		return $para;
	}
	
	/**
	* 生成签名结果
	* @param $para_sort 已排序要签名的数组
	* return 签名结果字符串
	*/
	private function buildRequestMysign($para_sort) {
		//把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
		$prestr = $this->createLinkstring($para_sort);
		
		$mysign = $this->rsaSign($prestr, $this->private_key);

		return $mysign;
	}
    
    /**
	 * 验证签名结果
	 * @param $para_temp 通知返回来的参数数组
	 * @param $sign 返回的签名结果
	 * @return 签名验证结果
	 */
	private function getSignVeryfy($para_temp, $sign) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = $this->paraFilter($para_temp);
		
		//对待签名参数数组排序
		$para_sort = $this->argSort($para_filter);
		
		//把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
		$prestr = $this->createLinkstring($para_sort);
		
		$isSgin = false;
		$isSgin = $this->rsaVerify($prestr, $this->alipay_public_key, $sign);
		
		return $isSgin;
	}
	
	/**
	 * 把数组所有元素，按照"参数=参数值"的模式用"&"字符拼接成字符串
	 * @param $para 需要拼接的数组
	 * return 拼接完成以后的字符串
	 */
	private function createLinkstring($para) {
		$arg  = "";
		while (list ($key, $val) = each ($para)) {
			$arg.=$key."=".$val."&";
		}
		//去掉最后一个&字符
		$arg = substr($arg,0,count($arg)-2);
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){$arg = stripslashes($arg);}
		
		return $arg;
	}
    
    /**
     * RSA签名
     * @param $data 待签名数据
     * @param $private_key 商户私钥字符串
     * return 签名结果
     */
    private function rsaSign($data, $private_key) {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        $private_key=str_replace("-----BEGIN RSA PRIVATE KEY-----","",$private_key);
        $private_key=str_replace("-----END RSA PRIVATE KEY-----","",$private_key);
        $private_key=str_replace("\n","",$private_key);

        $private_key="-----BEGIN RSA PRIVATE KEY-----".PHP_EOL .wordwrap($private_key, 64, "\n", true). PHP_EOL."-----END RSA PRIVATE KEY-----";

        $res=openssl_get_privatekey($private_key);

        if($res)
        {
            openssl_sign($data, $sign,$res);
        }
        else {
            echo "您的私钥格式不正确!"."<br/>"."The format of your private_key is incorrect!";
            exit();
        }
        openssl_free_key($res);
        //base64编码
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * RSA验签
     * @param $data 待签名数据
     * @param $alipay_public_key 支付宝的公钥字符串
     * @param $sign 要校对的的签名结果
     * return 验证结果
     */
    private function rsaVerify($data, $alipay_public_key, $sign)  {
        //以下为了初始化私钥，保证在您填写私钥时不管是带格式还是不带格式都可以通过验证。
        $alipay_public_key=str_replace("-----BEGIN PUBLIC KEY-----","",$alipay_public_key);
        $alipay_public_key=str_replace("-----END PUBLIC KEY-----","",$alipay_public_key);
        $alipay_public_key=str_replace("\n","",$alipay_public_key);

        $alipay_public_key='-----BEGIN PUBLIC KEY-----'.PHP_EOL.wordwrap($alipay_public_key, 64, "\n", true) .PHP_EOL.'-----END PUBLIC KEY-----';
        $res=openssl_get_publickey($alipay_public_key);
        if($res)
        {
            $result = (bool)openssl_verify($data, base64_decode($sign), $res);
        }
        else {
            echo "您的支付宝公钥格式不正确!"."<br/>"."The format of your alipay_public_key is incorrect!";
            exit();
        }
        openssl_free_key($res);    
        return $result;
    }
    
    //获取支付宝配置
    private function config()
    {
        $config = payConfig(['cache'=>true, 'controll'=>'alipayold']);
        if($config['status'] == 'normal'){
            $this->partner           = $config['partner'];
            $this->private_key       = $config['private_key'];
            $this->alipay_public_key = $config['alipay_public_key'];
            return $config;
        }
        return false;
    }
}
?>