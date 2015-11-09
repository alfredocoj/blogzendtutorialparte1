<?php
namespace Core\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Core\Model\TableGateway;

class ActionController extends AbstractActionController
{
	
    protected $entityManager;

    /**
     * Returns a TableGateway
     *
     * @param  string $table
     * @return TableGateway
     */
	protected function getTable($table)
    {
        $sm = $this->getServiceLocator();
        $dbAdapter = $sm->get('DbAdapter');
        $tableGateway = new TableGateway($dbAdapter);
        $object = new $table();
        $tableGateway->initialize($object->getTableName(), $object);
        return $tableGateway;
    }

    // Obs.: Método referentes ao Doctrine
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

    // Obs.: Método referentes ao Doctrine
    /**
     * Returns a Service referente ao mapeamento ORM do Doctrine
     *
     * @param  string $service
     * @return Service
     */
    protected function getEntityManager()
    {
        if (null === $this->entityManager) {
            $this->entityManager = $this->getService('Doctrine\ORM\EntityManager');
        }

        return $this->entityManager;
    }
}