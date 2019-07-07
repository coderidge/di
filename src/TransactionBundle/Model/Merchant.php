<?php

namespace TransactionBundle\Model;

/**
 * Class Merchant
 * @description retrieves transactions for a single merchant id and uses the currency converter to convert to users currency
 * @id integer
 */
class Merchant
{

    const TRANSACTION_MECHANT_ID = 0;
    const TRANSACTION_DATE = 1;
    const TRANSACTION_VALUE = 2;
    const TRANSACTION_CURRENCY = 'GBP';

    /**
     * @var TransactionTable
     */
    private $transactions;

    /**
     * @var CurrencyConverter
     */
    private $currencyConverter;

    /**
     * Merchant constructor.
     * @param CurrencyConverter $currencyConverter
     * @param TransactionTable $transactions
     */
    public function __construct(CurrencyConverter $currencyConverter, TransactionTable $transactions)
    {
        $this->transactions = $transactions;
        $this->currencyConverter = $currencyConverter;
    }

    /**
     * @param int $id
     * @return array|\Exception|string
     */
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
                /**
                 * This part need to be fixed because it cannot be tested properly. Please look spec function test
                 * My thought is this has to be moved into currencyConverter because if you can see here many constant properties are
                 * I think it has to be like this:
                 *
                 * $this->currencyConverter->convert($transaction[Merchant::TRANSACTION_VALUE]);
                 *
                 * and all have to be moved to Currency Converter into a method:
                 * number_format(preg_replace('/[^0-9-.]+/', '',$value), 2), mb_substr($value, 0, 1, 'UTF-8')
                 *
                 * Feel free to figure out your best solution
                 */
                $amount = $this->currencyConverter->convert(number_format(preg_replace('/[^0-9-.]+/', '',
                    $transaction[Merchant::TRANSACTION_VALUE]), 2),
                    mb_substr($transaction[Merchant::TRANSACTION_VALUE], 0, 1, 'UTF-8'));
                $conversion[] = [
                    'merchantId' => $transaction[static::TRANSACTION_MECHANT_ID],
                    'amount' => $amount,
                    'currency' => static::TRANSACTION_CURRENCY,
                    'date' => $transaction[static::TRANSACTION_DATE]
                ];
            }

            return $conversion;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
