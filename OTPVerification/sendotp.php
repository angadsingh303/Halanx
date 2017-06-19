<?php
session_start();

class SendOTP
{
  private $baseUrl = "http://api.msg91.com/api/";
  private $authkey = "156475AqwVs2L85943c29d"; // 

  public function submitOTP($request)
  {
    $mobile = $request['mobileNumber']; //Keep number in international format (with country code)
    $message = "Your Verification Code for HALANX Is ##OTP##."; // Message content to send. (default : Your verification code is ##OTP##.)
    $sender = "HALANX";   //Receiver will see this as sender's ID. (default : OTPSMS)
    $data = array( "authkey" => $this->authkey,
     "mobile" => $mobile,
     "message" => $message,
     "sender" => $sender,
                 // "otp" => $otp,
     );

    $url=$this->baseUrl."sendotp.php";
    $response =  $this->dataProcess($url,$data);

    $response = json_decode($response, true);

    if ($response["type"] == "error") {
      //customize this as per your framework
     
      return $response["type"];;
    }

    return "OTP SENT SUCCESSFULLY";
  }

  public function verifyBySendOtp($request)
  {
   $url=$this->baseUrl."verifyRequestOTP.php";

    $mobile = $request['mobileNumber']; //Keep number in international format (with country code)
     $otp = $request['oneTimePassword'];  //OTP to verify

     $data = array(  "authkey" => $this->authkey,
      "mobile" => $mobile,
      "otp" => $otp,
      );

     $response =  $this->dataProcess($url,$data);
     $response = json_decode($response, true);
     if ($response["type"] == "error") {
      return $response["message"];

    }  

    return "NUMBER VERIFIED SUCCESSFULLY";        
    
  }

  
  function dataProcess($url,$data){

  // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_POST => true,
      CURLOPT_POSTFIELDS => $data
                 //,CURLOPT_FOLLOWLOCATION => true
      ));
   //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    //get response
    $output = curl_exec($ch);

   //Print error if any 
    if(curl_errno($ch))
    { 
     echo 'error: ' . curl_error($ch);
     return curl_error($ch);
   }
   curl_close($ch);
   
   return $output;
 }

}

$sendOTPObject = new SendOTP();

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
  $funname = $_REQUEST['action'];
 // var_dump($_REQUEST);
  switch ($funname) {
    case 'submitOTP':
    echo $sendOTPObject->submitOTP($_REQUEST);
    break;

    case 'verifyBySendOtp':
    echo $sendOTPObject->verifyBySendOtp($_REQUEST);
    break;     

    default:
    echo "Error Wrong api";
    break;
  }

}
?>
