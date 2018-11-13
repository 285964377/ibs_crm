<?php
namespace Wxpay\Controller;
use Think\Controller;
require_once 'lib/wxpay.php';
require_once 'lib/qrcode.php';
/*

$pay_data 订单信息

	$pay_data['pay_sn']   		//订单号  
	$pay_data['body']   		//本次订单的简要描述
	$pay_data['money']   		//订单金额
	$pay_data['product_id']   	//不知道干什么用，反正JSAPI必须填
	$pay_data['openid']   		//用户的openid  （app支付、二维码、H5支付不需要传该参数）
	
	可以定义一些其他的自定义参数，如下单人用户类型，订单类型
	
	使用方法 直接在ajax中请求 Wxpay/Wxpay/index 会返回下单结果 如果return_code='FAIL' 或者 ERROR 就提示 return_msg
	
*/

class WxpayController extends Controller {
	
	public function index(){
	    if(IS_AJAX){
            $pay_way=(I('param.pay_way')?I('param.pay_way'):1);
            $money=(I('param.money')?I('param.money'):1);
            $openid=(I('param.openid')?I('param.openid'):'oah1R1pgEx5ujUroWTHD9zZr5xw4');
            $body=(I('param.body')?I('param.body'):'会员充值');
            $config=M('config_wx')->find();
            $pay_data=array(
                'money' => $money,
                'openid' => $openid,
                'pay_sn' => date('YmdHis') . uniqid(),
                'create_time' => time(),
                'body' => $body,
                'product_id' => MD5(date('YmdHis') . uniqid())
            );
            switch($pay_way){
                case '1':
                    $this->jsapi_pay($config,$pay_data);
                case '2':
                    $this->app_pay($config,$pay_data);
                case '3':
                    $this->code_pay($config,$pay_data);
                case '4':
                    $this->web_pay($config,$pay_data);
                case '5':
                    $this->company_pay($config,$pay_data);
                default:
                    echo json_encode(['return_code'=>'ERROR','return_msg'=>'错误的支付类型']);
                    exit;
            }
        }else{
            $config=M('config_wx')->find();
            $wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['secret'], $config['key']);
            $openid=session('openid');
            if(!$openid){
                $openid = $wxpay->GetOpenid();
                session('openid',$openid);
            }
            $this->assign('openid',$openid);
            $this->display();
        }

	}
	
//APP 支付
	public function app_pay($config,$pay_data){
		$notify_url=U('Wx/Wxpay/app_notify_url','','',true);
		$wxpay = new \wxpay($config['app_appid'], $config['app_mch_id'], $config['app_secret'], $config['app_key'],$notify_url);
		$appParameters = $wxpay->getAppCode($pay_data);
		echo json_encode($appParameters,true);
		exit;
	}
	
//JSAPI 支付
	public function jsapi_pay($config,$pay_data){
		$notify_url=U('Wx/Wxpay/wx_notify_url','','',true);
		$wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['secret'], $config['key'],$notify_url);
		$jsParameters=$wxpay->getCode($pay_data);				//微信支付，获取JSSDK的参数
		echo json_encode($jsParameters,true);
		exit;
	}


//二维码支付
	public function code_pay($config,$pay_data){
		$notify_url=U('Wx/Wxpay/wx_notify_url','','',true);
		$wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['secret'], $config['key'],$notify_url);
		$return=$wxpay->GetPrePayUrl($pay_data);		//微信支付，获取支付链接（H5,扫码）
		if($return['code_url']){		//下单成功 生成二维码
			$qe = new \QRcode();
			$url =$return['code_url']; 
			$filename ='uploader/upload/wx_pay_code/'.$pay_data['pay_sn'].'.png';
			$qe::png($url, $filename, 'Q', 20,2,true);   //true 保存文件 false 不保存文件
            $file =  C('TMPL_PARSE_STRING')['__WWW__'].'/'.$filename;
            echo $file;
            exit;
		}else{
			echo json_encode($return,true);
			exit;
		}
	}

//H5支付	
   public function web_pay($config,$pay_data){
		$notify_url=U('Wx/Wxpay/wx_notify_url','','',true);
		$wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['secret'], $config['key'],$notify_url);
		$return=$wxpay->GetPrePayUrl($pay_data);		//微信支付，获取支付链接（H5,扫码）
		echo json_encode($return,true);
		exit;
	}

//企业付款到零钱
   public function company_pay($config,$pay_data){
	   $wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['appSecret'], $config['key'],'',$sslCertPath='',$sslKeyPath='');
	   $return=$wxpay->wx_company_pay($pay_data);
	   echo json_encode($return,true);
	   exit;
   }

   
//微信支付回调
  public function wx_notify_url(){
        $config=M('config_wx')->find();
	    $wxpay = new \wxpay($config['appid'], $config['mch_id'], $config['appSecret'], $config['key']);
		$order=$wxpay->notify();
		if($order){
			//这里写付款成功的逻辑 $order 是微信返回的订单信息
            $log['pay_sn']=$order['pay_sn'];
            $log['cus_name']=$order['cus_name'];
            $log['cus_tel']=$order['cus_tel'];
            $log['cus_card']=$order['cus_card'];
            $log['worker_name']=$order['worker_name'];
            $log['worker_code']=$order['worker_code'];
            $log['money']=$order['total_fee']/100;
            M('active_recharge_log')->add($log);
		}
  }
  
//app支付回调
   public function app_notify_url(){
       $config=M('config_wx')->find();
	    $wxpay = new \wxpay($config['app_appid'], $config['app_mch_id'], $config['app_secret'], $config['app_key']);
		$order=$wxpay->notify();
		if($order){
			//这里写付款成功的逻辑	$order 是微信返回的订单信息

		}
  }
	
}
?>