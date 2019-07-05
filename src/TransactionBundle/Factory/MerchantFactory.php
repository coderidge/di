<?php
namespace TransactionBundle\Factory;

use TransactionBundle\Model\CurrencyConverter;
use TransactionBundle\Model\TransactionTable;
use TransactionBundle\Model\Merchant;

/**
 * Class MerchantFactory
 * @description is a factory class which we can then use in the constructor of our controller
 * to use the merchant model with an id
 * @param $id integer
 */

class MerchantFactory {

private $currencyConverter;
private $transactions;


public function getMerchantForId(int $id) {

    $this->currencyConverter = new CurrencyConverter();
    $this->transactions = new TransactionTable();

    return new Merchant($id, $this->currencyConverter, $this->transactions);

    }
}