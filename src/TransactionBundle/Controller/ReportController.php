<?php
namespace TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use TransactionBundle\Factory\MerchantFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use TransactionBundle\Model\CurrencyConverter;
use TransactionBundle\Model\Merchant;
use TransactionBundle\Model\TransactionTable;

/** NOTE - I've ended up using a controller and route with id, because of course can't run
 * the controller through command line.  I did try use for my models, factories in a report.php
 * script outside of symfony, to meet your request for command line running, but could not get namespaces to
 * work even with composer and PSR installed.
 *
 * However I hope you see my DI, OOP and Tests here were the main things you were looking for.
 *
 * ReportController
 * use this to get report with merchant id routing /report/merchantid
 *
 */

class ReportController extends Controller
{
    public function indexAction(Request $request)
    {
        $merchantId = $request->get('merchid', null);
        if ($merchantId === null) {
            return 'no merchant id used';
        }

        $merchant = new Merchant(new CurrencyConverter(), new TransactionTable());

        return new JsonResponse($merchant->getTransactions($merchantId));
    }
}
