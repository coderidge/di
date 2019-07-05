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

class MerchantFactory
{
    public function getMerchantForId()
    {
        return new Merchant(new CurrencyConverter(), new TransactionTable());
    }
}
