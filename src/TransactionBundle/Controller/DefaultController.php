<?php

namespace TransactionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {

        print_r('hi');
       // return $this->render('TransactionBundle:Default:index.html.twig');
    }
}
