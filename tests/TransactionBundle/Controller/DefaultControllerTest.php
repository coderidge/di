<?php

namespace TransactionBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use TransactionBundle\Model\CurrencyConverter;
use TransactionBundle\Model\CurrencyWebservice;
use TransactionBundle\Model\Merchant;
use TransactionBundle\Model\TransactionTable;

/**
 * Class DefaultControllerTest
 * @package TransactionBundle\Tests\Controller
 *
 * @tests
 * currency returns number
 * wrong currency returns currency not found message
 * conversion returns an number value
 * calculation result less than 0 returns calculation wrong message
 * no data returned for that id returns correct message
 */

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {

        $transaction = new TransactionTable();

        $data = $transaction->getData();

        $this->assertNotEmpty($data);

   }

    public function testReportNoId() {

        $currencyConverter = new CurrencyConverter();
        $transactions = new TransactionTable();

        $merchant = new Merchant(0,$currencyConverter,$transactions);

        $result = $merchant->getTransactions();

       $this->assertSame($result,'no id entered');

    }

    public function testReportDatanotfoundforid() {

        $currencyConverter = new CurrencyConverter();
        $transactions = new TransactionTable();

        $merchant = new Merchant(8,$currencyConverter,$transactions);

        $result = $merchant->getTransactions();

        $this->assertSame($result,'no data found for this id');

    }


    // check returns a value and it's an int
    public function testExchangerate() {

        $ex = new CurrencyWebservice();

        $result = $ex->getExchangeRate('$');

        $this->assertIsNumeric($result);

    }

      public function testExchangeratenotentered() {

        $ex = new CurrencyWebservice();

        $result = $ex->getExchangeRate('');

        $this->assertSame($result,'currency not entered');

    }

    public function testExchangerateNotexist() {
        $ex = new CurrencyWebservice();
        $result = $ex->getExchangeRate('Kč');
        $this->assertSame($result,'currency not found');

    }

    public function testCurrencyConverterDollars() {

        $convert = new CurrencyConverter();

        $result = $convert->convert('10','$');
        // convert to dollars
        $this->assertIsNumeric($result);
    }

    public function testCurrencyConverterErrorMessage() {

        $convert = new CurrencyConverter();

        $result = $convert->convert('-10','$');
        // convert to dollars
        $this->assertSame($result,'an error occurred in the calculation');
    }


}
