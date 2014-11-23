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

/************************** AVS Variables *****************************/

$avs_street_number = '201';
$avs_street_name = 'Michigan Ave';
$avs_zipcode = 'M1M1M1';

/************************** CVD Variables *****************************/

$cvd_indicator = '1';
$cvd_value = '198';

/********************** AVS Associative Array *************************/

$avsTemplate = array(
		     		 avs_street_number=>$avs_street_number,
                     avs_street_name =>$avs_street_name,
                     avs_zipcode => $avs_zipcode
                    );

/********************** CVD Associative Array *************************/

$cvdTemplate = array(
		     		 cvd_indicator => $cvd_indicator,
                     cvd_value => $cvd_value
                    );

/************************** AVS Object ********************************/

$mpgAvsInfo = new mpgAvsInfo ($avsTemplate);

/************************** CVD Object ********************************/

$mpgCvdInfo = new mpgCvdInfo ($cvdTemplate);

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

/********************** Transaction Object ****************************/

$mpgTxn = new mpgTransaction($txnArray);

/************************ Set AVS and CVD *****************************/

$mpgTxn->setAvsInfo($mpgAvsInfo);
$mpgTxn->setCvdInfo($mpgCvdInfo);

/************************ Request Object ******************************/

$mpgRequest = new mpgRequest($mpgTxn);

/*********************** HTTPS Post Object ****************************/

$mpgHttpPost  =new mpgHttpsPost($store_id,$api_token,$mpgRequest);

/*************************** Response *********************************/

$mpgResponse=$mpgHttpPost->getMpgResponse();

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
print("\nAVSResponse = " . $mpgResponse->getAvsResultCode());
print("\nCVDResponse = " . $mpgResponse->getCvdResultCode());
print("\nCardLevelResult = " . $mpgResponse->getCardLevelResult());

?>