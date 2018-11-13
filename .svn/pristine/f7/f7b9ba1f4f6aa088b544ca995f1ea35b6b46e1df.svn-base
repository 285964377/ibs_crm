<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2018 http://www.ehecd.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 样子 < 87495363@qq.com>
// +----------------------------------------------------------------------
class wxpay {

    public function __construct($appid,$mch_id,$appSecret,$key,$notify='',$sslCertPath='',$sslKeyPath='')
    {
        defined('WEIXIN_APPID') or define('WEIXIN_APPID',$appid);
        defined('WEIXIN_MCHID') or define('WEIXIN_MCHID',$mch_id);
        defined('WEIXIN_APPSECRET') or define('WEIXIN_APPSECRET',$appSecret);
        defined('WEIXIN_KEY') or define('WEIXIN_KEY',$key);
        defined('WEIXIN_SSLCERT_PATH') or define('WEIXIN_SSLCERT_PATH',PLUGINS_PATH.'/wxpay/'.$sslCertPath);
        defined('WEIXIN_SSLKEY_PATH') or define('WEIXIN_SSLKEY_PATH',PLUGINS_PATH.'/wxpay/'.$sslKeyPath);
        defined('WEIXIN_CURL_PROXY_HOST') or define('WEIXIN_CURL_PROXY_HOST',"0.0.0.0");
        defined('WEIXIN_CURL_PROXY_PORT') or define('WEIXIN_CURL_PROXY_PORT',0);
        defined('WEIXIN_REPORT_LEVENL') or define('WEIXIN_REPORT_LEVENL',1);
        defined('WEIXIN_NOTIFY_URL') or define('WEIXIN_NOTIFY_URL',$notify);
        defined('NOW_TIME') or define('NOW_TIME',time());
        require_once "wxpay/WxPay.Api.php";
        require_once "wxpay/WxPay.JsApiPay.php";
    }
	
	//获取预支付url，用于返回URL 由用户扫码，或者直接将用户重定向到这个支付页（相当于H5支付）
    public function GetPrePayUrl($pay_data){
        $input = new WxPayUnifiedOrder();
        $input->SetBody($pay_data['body']);
        $input->SetAttach($pay_data['body']);
        $input->SetOut_trade_no($pay_data['pay_sn']);
        $money= $pay_data['money'] *100;
        $input->SetTotal_fee("$money");
        $input->SetTime_start(date("YmdHis"));
        $input->SetGoods_tag($pay_data['body']);
        $input->SetNotify_url(WEIXIN_NOTIFY_URL);
        $input->SetTrade_type("NATIVE");
        $input->SetProduct_id($pay_data['order_id']);
        $return_order = WxPayApi::unifiedOrder($input);
        return $return_order;
    }
	
	//
    public function getAppCode($pay_data){
        $input = new WxPayUnifiedOrder();
        $input->SetBody($pay_data['body']);
        $input->SetAttach($pay_data['body']);
        $input->SetOut_trade_no($pay_data['pay_sn']);
        $money= $pay_data['money'] *100;
        $input->SetTotal_fee("$money");
        $input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 3000));
        $input->SetGoods_tag($pay_data['body']);
        $input->SetNotify_url(WEIXIN_NOTIFY_URL);
        $input->SetTrade_type("APP");
        $order = WxPayApi::unifiedOrder($input);

        if($order['return_code']=='SUCCESS' && $order['result_code']='SUCCESS'){
            $data = new WxPayAppPay();

            $data->SetAppid($order['appid']);
            $data->SetPartnerid($order['mch_id']);
            $data->SetPrepayid($order['prepay_id']);
            $data->SetPackage("Sign=WXPay");
            $data->SetNonceStr(WxPayApi::getNonceStr());
            $data->SetTimeStamp(NOW_TIME);
            $data->SetSign();
            return $data->GetValues();
        }else{
            return $order;
        }
    }

    //获取微信公众号openid
    public function getOpenid(){
        $tools = new JsApiPay();
        $code=$_GET['code'];
        $openId = $tools->GetOpenid($code);
        return $openId;
    }

    public function getCode($pay_data) {
        //①、获取用户openid
        $tools = new JsApiPay();
        if(!empty($pay_data['openid'])){
            $openId = $pay_data['openid'];
        }else{
            $code=$_GET['code'];
            $openId = $tools->GetOpenid($code);
        }
        $input = new WxPayUnifiedOrder();
        $input->SetBody($pay_data['body']);
        $input->SetAttach($pay_data['body']);
        $input->SetOut_trade_no($pay_data['pay_sn']);
        $money = $pay_data['money'] *100;
        $input->SetTotal_fee("$money");
        $input->SetTime_start(date("YmdHis"));
        //$input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag($pay_data['body']);
        $input->SetNotify_url(WEIXIN_NOTIFY_URL);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
		if($order['return_code']=='SUCCESS' && $order['result_code']='SUCCESS'){
			$jsApiParameters = $tools->GetJsApiParameters($order);
			return $jsApiParameters;
		}else{
			return $order;
		}
        
    }

    //原路退款
    public function wx_refund($order){
        $input = new WxPayRefund();
        $input->SetOut_trade_no($order['pay_sn']);
        $input->SetTotal_fee(intval(strval($order['total_money']*100)));
        $input->SetRefund_fee(intval(strval($order['money']*100)));
        $input->SetOut_refund_no($order['refund_no']);
        $input->SetOp_user_id(WEIXIN_MCHID);
        $result = WxPayApi::refund($input);
        if (($result['return_code']=='SUCCESS') && ($result['result_code']=='SUCCESS')) {
            return true;
        }else{
            return $result;
        }
    }



    //企业付款
    public function wx_company_pay($data){
        $input = new WxCompanyPay();
        $input->SetOut_trade_no($data['pay_sn']);
        $input->SetDesc($data['body']);
        $input->SetAmount($data['money']*100);
        $input->SetOpenid($data['openid']);
        $result = WxPayApi::company_pay($input);
        if (($result['return_code']=='SUCCESS') && ($result['result_code']=='SUCCESS')) {
            return true;
        }else{
            $res=$this->get_wx_company_pay($data['pay_sn']);
            if($res===true){
                return true;
            }else{
                return $result['err_code_des'];
            }
        }
    }

    //查询企业付款
    public function get_wx_company_pay($pay_sn){
        $input = new GetWxCompanyPay();
        $input->SetOut_trade_no($pay_sn);

        $result = WxPayApi::get_company_pay($input);

        if (($result['return_code']=='SUCCESS') && ($result['result_code']=='SUCCESS')&& ($result['status']=='SUCCESS')) {
            return true;
        }else{
            return $result['return_msg'];
        }
    }

    //检查是否回调成功
    public function notify(){
        $xml = file_get_contents("php://input");
        if (empty($xml)){
            return false;
        }
        $xml = new SimpleXMLElement($xml);
        if (!$xml){
            return false;
        }
        $data = array();
        foreach ($xml as $key => $value) {
            $data[$key] = strval($value);
        }
        if (empty($data['return_code']) || $data['return_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['result_code']) || $data['result_code'] != 'SUCCESS') {
            return false;
        }
        if (empty($data['out_trade_no'])){
            return false;
        }
        ksort($data);
        reset($data);
        $sign = array();
        foreach ($data as $key => $val) {
            if ($key != 'sign') {
                $sign[] = $key . '=' . $val;
            }
        }

        //判断是微信浏览器微信支付还是APP微信支付，JSAPI是微信浏览器，APP是APP


        $sign[] = 'key=' . WEIXIN_KEY;
        $signstr = strtoupper(md5(join('&', $sign)));
        if ($signstr != $data['sign']){
            return false;
        }else{
            if($data['trade_type'] == "APP"){
                $data['wx_type']=2;
            }
            elseif($data['trade_type'] == "JSAPI"){
                $data['wx_type']=1;
            }
            elseif($data['trade_type'] == "NATIVE"){
                $data['wx_type']=3;
            }
            elseif($data['trade_type'] == "MWEB"){
                $data['wx_type']=4;
            }

            return $data;
        }
    }
}
