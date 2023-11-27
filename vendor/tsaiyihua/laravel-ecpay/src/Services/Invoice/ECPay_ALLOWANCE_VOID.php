<?php
namespace TsaiYiHua\ECPay\Services\Invoice;


use TsaiYiHua\ECPay\Exceptions\ECPayException;
use TsaiYiHua\ECPay\Services\ECPayService;

/**
 *  E折讓作廢
 */
class ECPay_ALLOWANCE_VOID implements ECPayService
{
    // 所需參數
    public $parameters = array(
        'TimeStamp'		=>'',
        'MerchantID'		=>'',
        'CheckMacValue'		=>'',
        'InvoiceNo'		=>'',
        'Reason' 		=>'',
        'AllowanceNo'		=>''
    );

    // 需要做urlencode的參數
    public $urlencode_field = array(
        'Reason' 		=> ''
    );

    // 不需要送壓碼的欄位
    public $none_verification = array(
        'Reason' 		=>'',
        'CheckMacValue'		=>''
    );

    /**
     * 1寫入參數
     */
    public function insertString(array $arParameters): array
    {

        foreach ($this->parameters as $key => $value) {
            if(isset($arParameters[$key])) {
                $this->parameters[$key] = $arParameters[$key];
            }
        }

        return $this->parameters ;
    }

    /**
     * 2-2 驗證參數格式
     */
    public function checkExtendString(array $arParameters): array
    {

        $arErrors = array();

        // 37.發票號碼 InvoiceNo
        // *必填項目
        if(strlen($arParameters['InvoiceNo']) == 0 ) {
            array_push($arErrors, '37:InvoiceNo is required.');
        }

        // *預設長度固定10碼
        if (strlen($arParameters['InvoiceNo']) != 10) {
            array_push($arErrors, '37:InvoiceNo length as 10.');
        }

        // 43.作廢原因 Reason
        // *必填欄位
        if(strlen($arParameters['Reason']) == 0) {
            array_push($arErrors, "43:Reason is required.");
        }

        // *字數限制在20(含)個字以內
        if( mb_strlen($arParameters['Reason'], 'UTF-8') > 20) {
            array_push($arErrors, "43:Reason max length as 20.");
        }

        // 44.折讓編號 AllowanceNo
        if(strlen($arParameters['AllowanceNo']) == 0) {
            array_push($arErrors, "44:AllowanceNo is required.");
        }

        // *若有值長度固定16字元
        if(strlen($arParameters['AllowanceNo']) != 0 && strlen($arParameters['AllowanceNo']) != 16 ) {
            array_push($arErrors, '44:AllowanceNo length as 16.');
        }

        if(sizeof($arErrors)>0) {
            throw new ECPayException(join('<br>', $arErrors));
        }

        return $arParameters ;
    }

    public function checkException(array $arParameters): array
    {
        return $arParameters ;
    }
}
