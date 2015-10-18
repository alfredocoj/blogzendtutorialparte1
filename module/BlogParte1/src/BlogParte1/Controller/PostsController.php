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
            $post = new Post;
            //$form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $data['post_date'] = date('Y-m-d H:i:s');
                $post->setData($data);
                
                $saved =  $this->getTable('Application\Model\Post')->save($post);
                return $this->redirect()->toUrl('/');
            }
        }

        return new ViewModel([
          'form' => $form
        ]);
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

        if($id){
            $post = $this->getEntityManager()->find('BlogParte1\Entity\Post', $id);
            $form->setData($post->getArrayCopy());
            $form->get('submit')->setAttribute('value', 'Edit');
        }

        if ($request->isPost()) {
            $post = new Post;
            //$form->setInputFilter($post->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $data['post_date'] = date('Y-m-d H:i:s');
                $post->setData($data);
                
                $saved =  $this->getTable('Application\Model\Post')->save($post);
                return $this->redirect()->toUrl('/');
            }
        }

        return new ViewModel([
          'form' => $form
        ]);
    }

    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0) {
            throw new \Exception("Código obrigatório");
        }
        
        $this->getTable('Application\Model\Post')->delete($id);
        return $this->redirect()->toUrl('/');
    }
}
