<?php
namespace BlogParte1\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\Exception\ServiceNotFoundException;

class ActionController extends AbstractActionController
{
    /**
     * Returns a Service
     *
     * @param  string $service
     * @return Service
     */
    protected function getService($service)
    {
        return $this->getServiceLocator()->get($service);
    }

    /**
     * Returns a Service referente ao mapeamento ORM do Doctrine
     *
     * @param  string $service
     * @return Service
     */
    protected function getEntityManager()
    {
        return $this->getService('Doctrine\ORM\EntityManager');
    }
}