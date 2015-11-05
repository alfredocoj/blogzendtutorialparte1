<?php
namespace Admin\Controller;

use Zend\View\Model\ViewModel;
use Core\Controller\ActionController;
use Admin\Entity\Comment;
use Admin\Form\CommentForm as CommentForm;

/**
 * Controlador que gerencia os posts
 *
 * @category Admin
 * @package Controller
 */
class CommentsController extends ActionController
{

    /**
     * Mostra os comments cadastrados
     * @return void
     */
    public function indexAction()
    {
        return new ViewModel(array(
            'comments' => $this->getTable('Admin\Entity\Comment')->fetchAll()->toArray()
        ));
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $form = new CommentForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $comment = new Comment;
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                $data['commentDate'] = date('Y-m-d H:i:s');
                $comment->exchangeArray($data);

                $saved =  $this->getTable('Admin\Entity\Post')->save($comment);
                return $this->redirect()->toUrl('/admin/comments/index');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $comment = $this->getTable('Admin\Entity\Comment')->get($id);
            echo "<pre>"; var_dump($comment); exit;
            $form->bind($comment);
            $form->get('submit')->setAttribute('value', 'Edit');
        }
            $form->get('postsId')
             ->setValueOptions(
                    $this->getService('Admin\Model\PostModel')
                         ->getPostsToPopuleSelect()
                );
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

        $this->getTable('Admin\Entity\Comment')->delete($id);
        return $this->redirect()->toUrl('/admin/comments/index');
    }

}
