<?php
namespace TransactionBundle\Model;

/**
 * Class Merchant
 * @description retrieves transactions for a single merchant id and uses the currency converter to convert to users currency
 * @id integer
 */
class Merchant
{
    public $_transactions;
    public $_currencyConverter;
    public $_id;

    public function __construct(int $id,CurrencyConverter $currencyConverter,TransactionTable $transactions)
    {
        $this->_transactions = $transactions;
        $this->_currencyConverter = $currencyConverter;
        $this->_id = $id;
    }

    public function getTransactions() {

        try {
            if(!$this->_id) {
                return 'no id entered';
            }

            // search for transaction by merchant id first, for purposes of this task filter by array value
            // assume that in real situation this would be call to database using select on id

            $data = $this->_transactions->getData();
              $array = array_filter($data, function ($ar) {
                return ($ar[0] == $this->_id);
            });

            if(empty($array)) {
                return 'no data found for this id';
            }

            $conversion = [];
            // convert the currencies, create useful and nice multidimensional array
            foreach ($array as $transaction) {
                $amount = $this->_currencyConverter->convert(number_format(preg_replace('/[^0-9-.]+/', '', $transaction['2']), 2), mb_substr($transaction['2'], 0, 1, 'UTF-8'));
                $conversion[] = array('merchantId' => $transaction[0], 'amount' => $amount, 'currency' => 'GBP', 'date' => $transaction[1]);
            }

            return $conversion;

        } catch(\Exception $e) {
            return $e;
        }

    }
}