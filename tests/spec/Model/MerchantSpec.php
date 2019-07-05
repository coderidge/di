<?php

namespace spec\TransactionBundle\Model;

use TransactionBundle\Model\CurrencyConverter;
use TransactionBundle\Model\TransactionTable;
use TransactionBundle\Model\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class MerchantSpec extends ObjectBehavior
{
    function it_returns_conversion_with(CurrencyConverter $converter, TransactionTable $transactionTable)
    {
        $dataReturn = [
            ['merchant', 'date', 'value'],
            [1, '01/05/2010', '£50.00']
        ];

        $transactionTable->getData()->willReturn($dataReturn);
        $this->beConstructedWith($converter, $transactionTable);
        $this->getTransactions(1)->shouldReturn([[
            'merchantId' => 1,
            'amount' => null, // the amount must be fixed because the value is cheated. That needs to be 50.00
            'currency' => 'GBP',
            'date' => '01/05/2010'
        ]]);
    }
}
