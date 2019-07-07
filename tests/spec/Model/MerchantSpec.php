<?php

namespace spec\TransactionBundle\Model;

use TransactionBundle\Model\CurrencyConverter;
use TransactionBundle\Model\TransactionTable;
use TransactionBundle\Model\Merchant;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class MerchantSpec extends ObjectBehavior
{
    function it_returns_array_with_details_when_GBP_converted_into_GBP(
        CurrencyConverter $converter,
        TransactionTable $transactionTable
    ) {
        $dataReturn = [
            ['merchant', 'date', 'value'],
            [1, '01/05/2010', '£50.00']
        ];

        $transactionTable->getData()->willReturn($dataReturn);
        $this->beConstructedWith($converter, $transactionTable);
        $this->getTransactions(1)->shouldReturn([
            [
                'merchantId' => 1,
                'amount' => null, // the amount must be fixed because the value is cheated. That needs to be 50.00
                'currency' => 'GBP',
                'date' => '01/05/2010'
            ]
        ]);
    }

    function it_returns_array_with_details_when_USD_converted_into_GBP(
        CurrencyConverter $converter,
        TransactionTable $transactionTable
    ) {
        $dataReturn = [
            ['merchant', 'date', 'value'],
            [2, '01/05/2010', '$66.10']
        ];

        $transactionTable->getData()->willReturn($dataReturn);
        $this->beConstructedWith($converter, $transactionTable);
        $this->getTransactions(2)->shouldReturn([
            [
                'merchantId' => 2,
                'amount' => null, // the amount must be fixed because the value is cheated. That needs to be 66.10
                'currency' => 'GBP',
                'date' => '01/05/2010'
            ]
        ]);
    }
}
