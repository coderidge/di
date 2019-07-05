<?php
namespace TransactionBundle\Model;

/**
 * Class Currency Converter
 * @description Converts amount into GBP for a given currency, formats to 2 decimal places
 * @param $amount integer
 * @param $curr string
 */
class CurrencyConverter
{
    public $_amount;
    public $_curr;

    public function convert(int $amount, string $curr)
    {
        try {
            $this->_amount = $amount;
            $this->_curr = $curr;

            $webservice = new CurrencyWebservice();
            // if return a number above 0
            if (number_format($this->_amount / $webservice->getExchangeRate($this->_curr), 2) > 0) {
                return number_format($this->_amount / $webservice->getExchangeRate($this->_curr), 2);
            } else {
                return 'an error occurred in the calculation';
            }
        } catch (\Exception $e) {
            return $e;
        }
    }
}
