<?php
namespace Admin\Controller;

use Core\Controller\ActionController;
use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Zend\View\Model\ViewModel;
use Admin\Form\CommentForm;
use Admin\Entity\Comment;

class CommentsController extends ActionController
{

    protected $menuBar = array();

    public function indexAction()
    {
        $id       = $this->params()->fromRoute('id');

        $comments = empty($id) ? $this->getService(Constantes::MODEL_COMMENT)->findAll() :
                        $this->getService(Constantes::MODEL_COMMENT)->getByAttributes(['postsId' => $id]);

        $novo = new MenuBarButton();

        $action = empty($id) ? '/admin/comments/create' : '/admin/comments/create-index/' . $id;
        $novo->setName('Novo')
             ->setAction($action)
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel([
                'menuButtons' => $this->menuBar,
                'comments'    => $comments,
            ]);

    }

    public function createAction()
    {
        $form    = new CommentForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $comment = new Comment();
                $comment->exchangeArray($form->getData());
                $post    = $this->getService(Constantes::MODEL_POST)->getById($comment->postsId);
                $comment->postsId = $post;

                $this->getService(Constantes::MODEL_COMMENT)->save($comment);
                $this->flashMessenger()->setNamespace('success')->addMessage('Comentário salvo com sucesso!');
                return $this->redirect()->toUrl('/admin/comments/index');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Dados inválidos.');
                return $this->redirect()->toUrl('/admin/comments/create');
            }

        }

        $form->get('postsId')->setValueOptions($this->getService(Constantes::MODEL_POST)->getPostsSelect());
        return new ViewModel([
                'form' => $form,
            ]);
    }

    public function createIndexAction()
    {

        $id = $this->params()->fromRoute('id');
        $form    = new CommentForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $comment = new Comment();
                $comment->exchangeArray($form->getData());
                $post    = $this->getService(Constantes::MODEL_POST)->getById($comment->postsId);
                $comment->postsId = $post;

                $this->getService(Constantes::MODEL_COMMENT)->save($comment);
                $this->flashMessenger()->setNamespace('success')->addMessage('Comentário salvo com sucesso!');
                return $this->redirect()->toUrl("/admin/comments/index/{$id}");
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Dados inválidos.');
                return $this->redirect()->toUrl('/admin/comments/create');
            }

        }

        $form->get('postsId')->setValueOptions($this->getService(Constantes::MODEL_POST)->getPostsSelect());
        return new ViewModel([
                'form' => $form,
                'postId' => $id,
            ]);
    }

    public function updateAction()
    {
        $commentId   = $this->params()->fromRoute('id');
        $commentPost = $this->getService(Constantes::MODEL_COMMENT)->getById($commentId);

        if (empty($commentPost)) {
            $this->flashMessenger->setNamespace('danger')->addMessage('Não existe um comentário com esse código!');
            return $this->redirect()->toUrl('/admin/comments/index');
        }

        $form    = new CommentForm();
        $request = $this->getRequest();
        $form->get('postsId')->setAttribute('data-id', $commentPost->postsId->id);
        $form->get('postsId')->setValueOptions($this->getService(Constantes::MODEL_POST)->getPostsSelect());
        $form->setData($commentPost->getArrayCopy());
        

        if ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $comment = new Comment();
                $comment->exchangeArray($form->getData());
                $comment->postsId = $this->getService(Constantes::MODEL_POST)->getById($comment->postsId);

                $this->getService(Constantes::MODEL_COMMENT)->update($comment, 'id');
                $this->flashMessenger()->setNamespace('success')->addMessage('Comentário atualizado com sucesso!');
                return $this->redirect()->toUrl('/admin/comments/index');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Comentário não atualizado: dados inválidos.');
                return $this->redirect()->toUrl('/admin/comments/index');
            }

        }

        return new ViewModel([
                'form' => $form,
            ]);
    }

    public function deleteAction()
    {
        $id = $this->params()->fromRoute('id');

        if ($id) {
            $comment = $this->getService(Constantes::MODEL_COMMENT)->getById($id);
            if (empty($comment)) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Você não tem permissão para excluir comentários.');
                return $this->redirect()->toUrl('/admin/comments/index');
            }

            try {
                $this->getService(Constantes::MODEL_COMMENT)->delete($id);
                $this->flashMessenger()->setNamespace('success')->addMessage('Exclusão realizada com sucesso.');
                return $this->redirect()->toUrl('/admin/comments/index');
            } catch (DBALException $e) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Exclusão não realizada.');
                return $this->redirect()->toUrl('/admin/comments/index');
            }
        }

        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal.');
        return $this->redirect()->toUrl('/admin/index');
    }
}
