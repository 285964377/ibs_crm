<?php
//阿里短信类
namespace Home\Controller;
use Think\Controller;
require_once "SignatureHelper.php";
use Aliyun\DySDKLite\SignatureHelper;
class AliController extends Controller {
	
	 /*
     * 发送短信
     *$tel  手机号  多个手机号 使用,隔开
	 *$fileds 字段
	 array('字段名'=>'123123','字段名'=>'yadan')
	 *$TemplateCode 模板号
     * */
	public function send_dx($tel,$TemplateCode,$fileds=array()){
			/*短信配置信息
			access_keyid				key
			access_keysecret			secret
			SignName					签名
			TemplateCode				模板号
			field						模板字段
			*/
			$config_ali=M('config_ali')->where('id=1')->find();
		    $basic=array(
				'access_keyid'=>$config_ali['access_keyid'],
				'access_keysecret'=>$config_ali['access_keysecret'],
				'SignName'=>$config_ali['sign_name'],
				'TemplateCode'=>$TemplateCode,
			);
			$params["PhoneNumbers"] = $tel;
			$params["SignName"] = $basic['SignName'];
			$params["TemplateCode"] = $basic['TemplateCode'];
			$params['TemplateParam'] =$fileds;
			$params['OutId'] = "12345";
			//  $params['SmsUpExtendCode'] = "1234567"; 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段

			if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
				$params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
			}
			// 初始化SignatureHelper实例用于设置参数，签名以及发送请求
			$helper = new SignatureHelper();
			$Config = array("RegionId" => "cn-hangzhou","Action" => "SendSms","Version" => "2017-05-25");
			$response = $helper->request($basic['access_keyid'],$basic['access_keysecret'],"dysmsapi.aliyuncs.com",array_merge($params,$Config));
		//	print_r($response);
			if($response->Code!='OK'){
				$code=explode('.',$response->Code)[1];
				if($code=='RAM_PERMISSION_DENY'){
					$msg = 'RAM权限DENY';
				}
				if($code=='OUT_OF_SERVICE'){
					$msg = '业务停机';
				}
				if($code=='PRODUCT_UN_SUBSCRIPT'){
					$msg = '未开通云通信产品的阿里云客户';
				}
				if($code=='PRODUCT_UNSUBSCRIBE'){
					$msg = '产品未开通';
				}
				if($code=='ACCOUNT_NOT_EXISTS'){
					$msg = '账户不存在';
				}
				if($code=='ACCOUNT_ABNORMAL'){
					$msg = '账户异常';
				}
				if($code=='SMS_TEMPLATE_ILLEGAL'){
					$msg = '短信模板不合法';
				}
				if($code=='SMS_SIGNATURE_ILLEGAL'){
					$msg = '短信签名不合法';
				}
				if($code=='INVALID_PARAMETERS'){
					$msg = '参数异常';
				}
				if($code=='SYSTEM_ERROR'){
					$msg = '系统错误';
				}
				if($code=='MOBILE_NUMBER_ILLEGAL'){
					$msg = '非法手机号';
				}
				if($code=='MOBILE_COUNT_OVER_LIMIT'){
					$msg = '手机号码数量超过限制';
				}
				if($code=='TEMPLATE_MISSING_PARAMETERS'){
					$msg = '模板缺少变量';
				}
				if($code=='BUSINESS_LIMIT_CONTROL'){
					$msg = '业务限流';
				}
				if($code=='INVALID_JSON_PARAM'){
					$msg = 'JSON参数不合法，只接受字符串值';
				}
				if($code=='BLACK_KEY_CONTROL_LIMIT'){
					$msg = '黑名单管控';
				}
				if($code=='PARAM_LENGTH_LIMIT'){
					$msg = '参数超出长度限制';
				}
				if($code=='PARAM_NOT_SUPPORT_URL'){
					$msg = '不支持URL';
				}
				if($code=='AMOUNT_NOT_ENOUGH'){
					$msg = '账户余额不足';
				}
			}else{
				$response->Code=200;
				$msg = '发送成功';
			}
			if(!$msg){
				$msg=$response->Code;
			}
			return array(
				'code'=>$response->Code,
				'msg'=>$msg,
			);
	}
	  
	
}
	