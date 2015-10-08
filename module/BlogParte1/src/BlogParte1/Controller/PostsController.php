<?php

namespace BlogParte1\Controller;

//use Zend\Mvc\Controller\AbstractActionController;
use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Core\Util\Constantes;
use BlogParte1\Entity\Post;
use BlogParte1\Form\PostForm;

class PostsController extends ActionController
{
    public function indexAction()
    {
        $posts = $this->getEntityManager()
                      ->getRepository('BlogParte1\Entity\Post')
                      ->findAll();
        //$posts = $this->getService(Constantes::MODEL_POSTS)->findAll();

        return new ViewModel([
                'posts'    => $posts,
            ]);
    }

    public function createAction()
    {
        $request = $this->getRequest();
        $form = new PostForm();

        if ( $request->getPost() ) {
            $form->setData($request->getPost());

            if ($form->isValid()){
                $post = new Post();
                $post->exchangeArray($form->getData());

                $this->getService(Constantes::MODEL_POSTS)->save($post);

                return $this->redirect()->toUrl('/blogparte1/posts/index');
            }
        }

        return new ViewModel([
          'form' => $form
        ]);
    }

    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $request = $this->getRequest();
        $form = new PostForm();
        $form->setAttribute('action', '/blogparte1/posts/update');

        if($id){
            $post = $this->getEntityManager()->find('BlogParte1\Entity\Post', $id);
            $form->setData($post->getArrayCopy());
        }

        elseif ( $request->isPost() ) {
            $form->setData($request->getPost());

            if ($form->isValid()){
                $post = new Post();
                $post->exchangeArray($form->getData());

                $repository = $this->getEntityManager();
                $update = $repository->find('BlogParte1\Entity\Post', $post->getId());
                $update->exchangeArray($post->getArrayCopy());
                $repository->flush();

                return $this->redirect()->toUrl('/blogparte1/posts/index');
            }
        }

        return new ViewModel([
          'form' => $form
        ]);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        // try get method
        if ( $id ) {
            $repository = $this->getEntityManager();

            $delete = $repository->find('BlogParte1\Entity\Post', $id);
          try{
              $repository->remove($delete);
              $repository->flush();
          } catch(Exception $e){
              echo $e->getMessage();
          }
        }
        return $this->redirect()->toUrl('/blogparte1/posts/index');
    }
}
