<?php

namespace BlogParte1\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListController extends AbstractActionController
{
    public function indexAction()
    {
      return new viewModel();
    }
}
