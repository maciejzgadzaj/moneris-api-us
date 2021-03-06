<?php

require "../mpgClasses.php";

/************************ Request Variables ***************************/

$store_id=$argv[1];
$api_token=$argv[2];

/********************* Transactional Variables ************************/

$type='us_purchase';
$order_id=$argv[3];
$cust_id=$argv[4];
$amount=$argv[5];
$pan=$argv[6];
$expiry_date=$argv[7];
$crypt='7';
$commcard_invoice='Invoice 5757FRJ8';
$commcard_tax_amount='0.15';


/************************** Recur Variables *****************************/

$recurUnit = 'day';
$startDate = '2006/11/30';
$numRecurs = '4';
$recurInterval = '10';
$recurAmount = '31.00';
$startNow = 'true';

/****************************** Recur Array **************************/

$recurArray = array(recur_unit=>$recurUnit,  // (day | week | month)
	start_date=>$startDate, //yyyy/mm/dd
	num_recurs=>$numRecurs,
	start_now=>$startNow,
	period => $recurInterval,
	recur_amount=> $recurAmount
	);

/****************************** Recur Object **************************/

$mpgRecur = new mpgRecur($recurArray);

/***************** Transactional Associative Array ********************/

$txnArray=array(
		type=>$type,
		order_id=>$order_id,
		cust_id=>$cust_id,
		amount=>$amount,
		pan=>$pan,
		expdate=>$expiry_date,
		crypt_type=>$crypt,
		commcard_invoice=>$commcard_invoice,
		commcard_tax_amount=>$commcard_tax_amount
          	);

/****************************** Transaction Object ********************/

$mpgTxn = new mpgTransaction($txnArray);


/****************************** Set Recur Object **********************/

$mpgTxn->setRecur($mpgRecur);


/****************************** Request Object **************************/

$mpgRequest = new mpgRequest($mpgTxn);


/****************************** mpgHttpsPost Object *********************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);


/****************************** Response ********************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();


/****************************** Receipt ********************************/

print ("\nCardType = " . $mpgResponse->getCardType());
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
print("\nRecurSuccess = " . $mpgResponse->getRecurSuccess());
print("\nCardLevelResult = " . $mpgResponse->getCardLevelResult());

?>
