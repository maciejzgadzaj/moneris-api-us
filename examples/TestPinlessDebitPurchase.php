<?php

require "../mpgClasses.php";

/************************ Request Variables **********************************/

$store_id=$argv[1];
$api_token=$argv[2];

/************************ Transaction Variables ******************************/

$orderid=$argv[3];
$amount=$argv[4];
$pan=$argv[5];
$expiry_date=$argv[6];
$presentation_type = $argv[7];
$intended_use = $argv[8];
$p_account_number = $argv[9];

/************************ Transaction Array **********************************/

$txnArray=array(type=>'us_pinless_debit_purchase',
				 order_id=>$orderid,
				 cust_id=>'cust',			//This field is optional
				 amount=>$amount,
				 pan=>$pan,
				 expdate=>$expiry_date,		//This field is optional
				 presentation_type=>$presentation_type,
				 intended_use=>$intended_use,
				 p_account_number=>$p_account_number
           		);


/************************ Transaction Object *******************************/

$mpgTxn = new mpgTransaction($txnArray);

/************************ Request Object **********************************/

$mpgRequest = new mpgRequest($mpgTxn);

/************************ mpgHttpsPost Object ******************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/************************ Response Object **********************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();


print("\nCardType = " . $mpgResponse->getCardType());
print("\nTransAmount = " . $mpgResponse->getTransAmount());
print("\nTxnNumber = " . $mpgResponse->getTxnNumber());
print("\nReceiptId = " . $mpgResponse->getReceiptId());
print("\nTransType = " . $mpgResponse->getTransType());
print("\nReferenceNum = " . $mpgResponse->getReferenceNum());
print("\nResponseCode = " . $mpgResponse->getResponseCode());
print("\nMessage = " . $mpgResponse->getMessage());
print("\nAuthCode = " . $mpgResponse->getAuthCode());
print("\nComplete = " . $mpgResponse->getComplete());
print("\nTransDate = " . $mpgResponse->getTransDate());
print("\nTransTime = " . $mpgResponse->getTransTime());
print("\nTicket = " . $mpgResponse->getTicket());
print("\nTimedOut = " . $mpgResponse->getTimedOut());


?>