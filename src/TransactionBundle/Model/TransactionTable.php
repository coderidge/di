<?php
namespace TransactionBundle\Model;

/**
 * Class transactionTable
 * @description open csv file and converts all data to an array
 *
 */
class TransactionTable
{
    public $_file;
    public $_data;

    public function getData()
    {

        try {
            $file = fopen((__DIR__ . '/../Resources/doc/data.csv'), "r");

            while (!feof($file)) {
                $arr[] = fgetcsv($file);
            }

            fclose($file);

            return $arr;
        } catch (\Exception $e) {
            return $e;
        }
    }
}
