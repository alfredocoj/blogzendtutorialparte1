<?php

namespace BlogParte1\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Core\Util\Constantes;

class PostsController extends ActionController
{
    public function indexAction()
    {
        $posts = $this->getEntityManager()
                      ->getRepository('Admin\Entity\Post')
                      ->findAll();
        //$posts = $this->getService(Constantes::MODEL_POST)->findAll();

        return new ViewModel([
                'posts'    => $posts,
            ]);
    }
}
