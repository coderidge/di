<?php

namespace TransactionBundle\Model;

/**
 * Class Merchant
 * @description retrieves transactions for a single merchant id and uses the currency converter to convert to users currency
 * @id integer
 */
class Merchant
{
    private $transactions;
    private $currencyConverter;

    public function __construct(CurrencyConverter $currencyConverter, TransactionTable $transactions)
    {
        $this->transactions = $transactions;
        $this->currencyConverter = $currencyConverter;
    }

    public function getTransactions(int $id)
    {
        try {
            if (!$id) {
                return 'no id entered';
            }

            // search for transaction by merchant id first, for purposes of this task filter by array value
            // assume that in real situation this would be call to database using select on id

            $data = $this->transactions->getData();
            $array = array_filter($data, function ($ar) use ($id) {
                return intval($ar[0]) === $id;
            });

            if (empty($array)) {
                return 'no data found for this id';
            }

            $conversion = [];
            // convert the currencies, create useful and nice multidimensional array
            foreach ($array as $transaction) {
                //This part need to be fixed because it cannot be tested properly. Please look spec function test
                $amount = $this->currencyConverter->convert(number_format(preg_replace('/[^0-9-.]+/', '',
                    $transaction['2']), 2), mb_substr($transaction['2'], 0, 1, 'UTF-8'));
                $conversion[] = [
                    'merchantId' => $transaction[0],
                    'amount' => $amount,
                    'currency' => 'GBP',
                    'date' => $transaction[1]
                ];
            }
var_dump($conversion);
            return $conversion;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
