<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Entity\Post;
use Admin\Form\PostForm as PostForm;

/**
 * Controlador que gerencia os posts
 * 
 * @category Admin
 * @package Controller
 */
class PostsController extends ActionController
{

    /**
     * Mostra os posts cadastrados
     * @return void
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'posts' => $this->getTable('Application\Entity\Post')->fetchAll()->toArray()
        ));
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $form = new PostForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $post = new Post;
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $data = $form->getData();

                $data['post_date'] = date('Y-m-d H:i:s');
                $post->exchangeArray($data);

                $saved =  $this->getTable('Application\Entity\Post')->save($post);
                if($saved)
                    $this->flashMessenger()->setNamespace('success')
                                       ->addMessage('Post salvo com sucesso.');
                else
                    $this->flashMessenger()->setNamespace('danger')
                        ->addMessage('Não foi possível salver esse poste. Tente novamente mais tarde.');
                return $this->redirect()->toUrl('/admin/posts/index');
            } else
                $this->flashMessenger()->setNamespace('danger')
                                       ->addMessage('Post não foi salvo. Erro de validação.');
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $post = $this->getTable('Application\Entity\Post')->get($id);
            $form->bind($post);
            $form->get('submit')->setAttribute('value', 'Edit');
        }
        return new ViewModel(
            array('form' => $form)
        );
    }
     
    /**
     * Exclui um post
     * @return void
     */
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id == 0)
            throw new \Exception("Código obrigatório");
        
        if($this->getTable('Application\Entity\Post')->delete($id))
            $this->flashMessenger()->setNamespace('success')
                 ->addMessage('Post deletado com sucesso.');
        else
            $this->flashMessenger()->setNamespace('danger')
                 ->addMessage('Não foi possível deletar esse registro. Tente novamente mais tarde.');
        return $this->redirect()->toUrl('/admin/posts/index');
    }

}
