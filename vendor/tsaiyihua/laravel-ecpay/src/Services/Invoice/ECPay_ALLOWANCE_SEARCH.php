<?php
namespace TsaiYiHua\ECPay\Services\Invoice;

use TsaiYiHua\ECPay\Exceptions\ECPayException;
use TsaiYiHua\ECPay\Services\ECPayService;

/**
 *  H查詢折讓明細
 */
class ECPay_ALLOWANCE_SEARCH implements ECPayService
{
    // 所需參數
    public $parameters = array(
        'TimeStamp'		=>'',
        'MerchantID'		=>'',
        'CheckMacValue'		=>'',
        'InvoiceNo'		=>'',
        'AllowanceNo'		=>''
    );

    // 需要做urlencode的參數
    public $urlencode_field = array(
        'ItemName' 		=>'',
        'ItemWord' 		=>'',
        'IIS_Customer_Name' 	=>''

    );

    // 不需要送壓碼的欄位
    public $none_verification = array(
        'ItemName'		=>'',
        'ItemWord'		=>'',
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

        // 44.折讓編號 AllowanceNo
        // *必填項目
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

    /**
     * 4欄位例外處理方式(送壓碼前)
     */
    public function checkException(array $arParameters): array
    {
        return $arParameters ;
    }
}
