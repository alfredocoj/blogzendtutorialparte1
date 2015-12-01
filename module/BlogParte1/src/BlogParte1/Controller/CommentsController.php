<?php
namespace BlogParte1\Controller;

use Zend\View\Model\ViewModel;
use BlogParte1\Form\CommentForm;
use BlogParte1\Entity\Comment;

class CommentsController extends ActionController
{

    public function indexAction()
    {
        $id       = $this->params()->fromRoute('id');

        $comments = !isset($id) ? $this->getEntityManager()
                                      ->getRepository('BlogParte1\Entity\Comment')
                                      ->findAll() :
                                 $this->getEntityManager()
                                      ->getRepository('BlogParte1\Entity\Comment')
                                      ->findBy(['postsId' => $id]);

        return new ViewModel([
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
                $post    = $this->getEntityManager()->find('BlogParte1\Entity\Post', $comment->getPostsId());
                $comment->setPostsId($post);

                $repository = $this->getEntityManager();
                $repository->persist($comment);
                $repository->flush();

                return $this->redirect()->toUrl('/blogparte1/comments/index');
            } else {
                return $this->redirect()->toUrl('/blogparte1/comments/create');
            }

        }

        $form->get('postsId')
             ->setValueOptions( 
                    $this->getService('BlogParte1\Model\PostModel')
                         ->getPostsToPopuleSelect() 
                );
        return new ViewModel([
                'form' => $form,
            ]);
    }

    public function updateAction()
    {
        $commentId   = $this->params()->fromRoute('id');
        
        $form    = new CommentForm();
        $form->setAttribute('action', '/blogparte1/comments/update');
        $request = $this->getRequest();

        if($commentId){
            $commentPost = $this->getEntityManager()
                            ->find('BlogParte1\Entity\Comment', $commentId);
            if (empty($commentPost)) {
                return $this->redirect()->toUrl('/blogparte1/comments/index');
            }
            $form->get('postsId')->setValueOptions($this->getService('BlogParte1\Model\PostModel')
                             ->getPostsToPopuleSelect());

            $form->setData($commentPost->getArrayCopy());
        }

        elseif ($request->isPost()) {
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $comment = new Comment();
                $comment->exchangeArray($form->getData());
                $comment->setPostsId( $this->getEntityManager()
                                           ->find('BlogParte1\Entity\Post', $comment->getPostsId()) 
                                );

                $repository = $this->getEntityManager();
                $update = $repository->find('BlogParte1\Entity\Comment', $comment->getId());
                $update->exchangeArray($comment->getArrayCopy());
                $repository->flush();

                return $this->redirect()->toUrl('/blogparte1/comments/index');
            } else {
                return $this->redirect()->toUrl('/blogparte1/comments/index');
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

            $comment = $this->getEntityManager()
                 ->find('BlogParte1\Entity\Comment', $id);
            if (empty($comment)) {
                return $this->redirect()->toUrl('/blogparte1/comments/index');
            }

            $repository = $this->getEntityManager();

            $comment = $repository->find('BlogParte1\Entity\Comment', $id);
            $repository->remove($comment);
            $repository->flush();

            return $this->redirect()->toUrl('/blogparte1/comments/index');
            
        }
        return $this->redirect()->toUrl('/blogparte1/index');
    }
}
