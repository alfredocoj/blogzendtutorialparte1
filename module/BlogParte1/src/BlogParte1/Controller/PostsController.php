<?php

namespace BlogParte1\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Core\Util\Constantes;
use BlogParte1\Entity\Post;
use BlogParte1\Form\PostForm;

class PostsController extends ActionController
{
    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {

        $posts = $this->getEntityManager()
                      ->getRepository('BlogParte1\Entity\Post')
                      ->findAll();

        return new ViewModel(array(
            'posts' => $posts
        ));
    }
     
    /**
     * Cria um post
     * @return void
     */
    public function createAction()
    {
        $form = new PostForm();
     
        $request = $this->getRequest();

        if ($request->isPost()) {
            $post = new Post();
            
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $post->exchangeArray($form->getData());

                $repository = $this->getEntityManager();
                $repository->persist($post);
                $repository->flush();

                return $this->redirect()->toUrl('/blogparte1/posts/index');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Edita um post
     * @return void
     */
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $request = $this->getRequest();
        $form = new PostForm();
        $form->setAttribute('action', '/blogparte1/posts/update');

        // try get method
        if ( $id ) {
            $post = $this->getEntityManager()->find('BlogParte1\Entity\Post', $id);

            if (!empty($post))
                $form->setData($post->getArrayCopy());
        }
        // try post method
        else if ($request->isPost()) {
            $post = new Post();

            $form->setData($request->getPost());

            if ($form->isValid())
            {
                $post->exchangeArray($form->getData());

                $repository = $this->getEntityManager();
                $update = $repository->find('BlogParte1\Entity\Post', $post->getId());
                $update->exchangeArray($post->getArrayCopy());
                $repository->flush();

                return $this->redirect()->toUrl('/blogparte1/posts/index');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $repository = $this->getEntityManager();

        $post = $repository->find('BlogParte1\Entity\Post', $id);

        if(!empty($post)){
           try {
                $repository->remove($post);
                $repository->flush();
           } catch (Exception $e) {
              error_log($e->getMessage());
           }
        } else {
           error_log("Você está tentando deletar um post que não existe.");
        }
        
        return $this->redirect()->toUrl('/blogparte1/posts/index');
    }
}