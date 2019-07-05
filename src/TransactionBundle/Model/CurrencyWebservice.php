<?php
namespace TransactionBundle\Model;
/**
 * Class Currency WebService
 *
 * @description a static dummy service to return exchange rates against GBP,
 * note included GBP so if wanted to use this function to exchange against a different currency, we only need to change
 * here, maybe identify the currency of the particular users country of origin for payment.
 *
 * @param $currency string;
 */
class CurrencyWebservice
{
    CONST USD = '1.5';
    CONST EURO = '2';
    CONST GBP = '1';

    private $_currency;

    public function getExchangeRate(string $currency)
    {

        try {

            if (!$currency) {
                return 'currency not entered';
            }

            $this->_currency = $currency;

            if ($this->_currency === '$') {
                return CurrencyWebservice::USD;
            } elseif ($this->_currency === "€") {
                return CurrencyWebservice::EURO;
            } elseif ($this->_currency === "£") {
                return CurrencyWebservice::GBP;
            } else {
                return 'currency not found';
            }
        } catch(\Exception $e) {
            return $e;
        }

    }
}