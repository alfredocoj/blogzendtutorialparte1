<?php

namespace Core\Controller;

use Doctrine\Common\EventSubscriber;

/**
 * Loga todas as alteraçòes nas entidades
 *
 */
class EntityLogger implements EventSubscriber
{
    /*
     * (non-PHPdoc) @see \Doctrine\Common\EventSubscriber::getSubscribedEvents()
     */
    public function getSubscribedEvents ()
    {
        return array(
            // 'onFlush',
            'postPersist'
        );
    }

    public function postPersist(\Doctrine\ORM\Event\LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $teste = $this->getServiceManager();

        echo "<pre>";
        var_dump($this->serviceManager);
        echo "<pre>";
        exit;
    }

    // public function postFlush(PostFlushEventArgs $eventArgs)
    // {
    //     if ($this->needsFlush) {
    //         $this->needsFlush = false;
    //         $eventArgs->getEntityManager()->flush();
    //     }
    // }

    /**
     * Loga as alteraçòes das entidades
     *
     * @param \Doctrine\ORM\Event\OnFlushEventArgs $eventArgs
     */
    // public function onFlush (\Doctrine\ORM\Event\OnFlushEventArgs $eventArgs)
    // {
    //     $em = $eventArgs->getEntityManager();
    //     $uow = $em->getUnitOfWork();

    //     foreach ($uow->getScheduledEntityInsertions() as $entity) {
    //         echo "<pre>";
    //         print_r( get_class($entity) );
    //         print_r( $uow->getIdentityMap() );
    //         print_r( json_encode($uow->getEntityChangeSet($entity)) );
    //         echo "<pre>";
    //         exit;

    //         // exit;$this->debug('Inserindo entidade ' . get_class($entity) . '. Campos: ' .
    //         //                  json_encode($uow->getEntityChangeSet($entity)));
    //     }

    //     foreach ($uow->getScheduledEntityUpdates() as $entity) {
    //         $add = '';
    //         if (method_exists($entity, '__toString')) {
    //             $add = ' '. $entity->__toString();
    //         } elseif (method_exists($entity, 'getId')) {
    //             $add = ' com id '. $entity->getId();
    //         }

    //         $this->debug('Alterando entidade ' . get_class($entity) . $add .'. Data: ' .
    //                          json_encode($uow->getEntityChangeSet($entity)));
    //     }

    //     foreach ($uow->getScheduledEntityDeletions() as $entity) {
    //         $add = '';
    //         if (method_exists($entity, '__toString')) {
    //             $add = ' '. $entity->__toString();
    //         } elseif (method_exists($entity, 'getId')) {
    //             $add = ' com id '. $entity->getId();
    //         }

    //         $this->debug('Removendo entidade ' . get_class($entity) . $add . '.');
    //     }
    // }
}
