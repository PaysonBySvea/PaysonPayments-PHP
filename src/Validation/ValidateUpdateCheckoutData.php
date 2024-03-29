<?php
/**
 *  @author    Payson AB <integration@payson.se>
 *  @copyright 2019 Payson AB
 *  @license   http://unlicense.org/
 */

namespace Payson\Payments\Validation;

/**
 * Class ValidateUpdateCheckoutData
 * @package Payson\Payments\Validation
 */
class ValidateUpdateCheckoutData extends ValidationService
{
    /**
     * @param array $data
     */
    public function validate($data)
    {
        $this->validateGeneralData($data);
        $this->validateMerchant($data);
        $this->validateOrder($data);
        $this->validateOrderItems($data);
    }
    
    /**
     * @param array $data
     * @throws PaysonException
     */
    private function validateGeneralData($data)
    {
        $this->mustNotBeEmptyArray($data, 'Checkout data');

        $requiredFields = array('id', 'status');
        foreach ($requiredFields as $field) {
            $this->mustBeSet($data, $field, $field);
        }
        
        $requiredFields = array('merchant', 'order');
        foreach ($requiredFields as $field) {
            $this->mustBeSet($data, $field, $field);
            $this->mustNotBeEmptyArray($data[$field], $field);
        }
    }
    
    /**
     * @param array $data
     * @throws PaysonException
     */
    private function validateMerchant($data)
    {
        $merchantData = $data['merchant'];
        $requiredFields = array('termsuri', 'checkouturi', 'confirmationuri', 'notificationuri');

        foreach ($requiredFields as $field) {
            $this->mustBeSet($merchantData, $field, 'Merchant ' . $field);
            $this->mustBeString($merchantData[$field], 'Merchant ' . $field);
            $this->lengthMustBeBetween(trim($merchantData[$field]), 9, 2000, 'Merchant ' . $field . ' should contain http:// or https:// and');
        }
    }
    
    /**
     * @param array $data
     * @throws PaysonException
     */
    private function validateOrder($data)
    {
        $this->mustBeSet($data['order'], 'currency', 'Currency');
        $this->mustBeString($data['order']['currency'], 'Currency');
        $this->mustBeInArray($data['order']['currency'], array('sek', 'eur', 'SEK', 'EUR', 'Sek', 'Eur'), 'Currency');

        $this->mustBeSet($data['order'], 'items', 'Order Items');
        $this->mustNotBeEmptyArray($data['order']['items'], 'Order Items');
    }
    
    /**
     * @param array $data
     * @throws PaysonException
     */
    private function validateOrderItems($data)
    {
        $requiredFields = array('name', 'quantity', 'unitprice');

        foreach ($data['order']['items'] as $orderItem) {
            foreach ($requiredFields as $field) {
                $this->mustBeSet($orderItem, $field, 'Order item ' . $field);
            }
            $this->mustBeString($orderItem['name'], 'Order item name ');
            $this->lengthMustBeBetween(trim($orderItem['name']), 1, 200, 'Order item name');
        }
    }
}
