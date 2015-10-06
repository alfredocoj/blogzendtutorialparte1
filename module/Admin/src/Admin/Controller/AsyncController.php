<?php
namespace Admin\Controller;

use Core\Controller\ActionController;
use Core\Util\Constantes;
use Zend\View\Model\JsonModel;

use Admin\Model\ModuloModel;
use Admin\Model\RecursoModel;
use Admin\Model\PerfilModel;
use Admin\Entity\Comment;

class AsyncController extends ActionController
{
    public function getModuloByIdAction()
    {
        $moduloModel = new ModuloModel();
        $moduloModel->setEntityManager($this->getEntityManager());
        $modulo = $moduloModel->getById(1);

        $result = new JsonModel($modulo);

        return $result;
    }
    public function getRecursosByModuloIdAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $recursoModel = $this->getService(Constantes::MODEL_RECURSO);

        $recursos = $recursoModel->getAllItensToSelectByAttributesJsonReturn(array('rcs_mod_id' => $id), 'rcs_id', 'rcs_nome');

        $result = new JsonModel($recursos);

        return $result;
    }

    public function getPerfisByModuloIdAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        $perfilModel = $this->getService(Constantes::MODEL_PERFIL);
        $perfis = $perfilModel->getByModuloId($id);

        $result = new JsonModel($perfis);

        return $result;
    }

    public function getCommentsAction()
    {
        $id      = $this->params()->fromRoute('id');
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest() and $id) {
            $comments = $this->getService(Constantes::MODEL_COMMENT)->getByAttributes(['postsId' => $id]);

            if ($comments) {
                foreach ($comments as $key => $value) {
                    $return[] = [
                        'description' => $value->description,
                        'author'      => $value->name,
                        'email'       => $value->email,
                        'webpage'     => $value->webpage,
                    ];
                }
                return new JsonModel($return);
            }
            return new JsonModel();
        }
        return new JsonModel();
    }

    public function salvarComentarioAction()
    {
        $request = $this->getRequest();
        //file_put_contents("./data/post.txt", serialize($request->getPost()));
        //return new JsonModel([$request->isXmlHttpRequest()]);
        if ($request->isPost()) {
            $comment = new Comment();
            $comment->exchangeArray($request->getPost()->getArrayCopy());
            $post    = $this->getService(Constantes::MODEL_POST)->getById($comment->postsId);
            $comment->postsId = $post;
            try {
                $this->getService(Constantes::MODEL_COMMENT)->save($comment);
                return new JsonModel(['response' => 'ok']);
            } catch (\Exception $e) {
                return new JsonModel(['response' => 'notsave']);
            }
        }

        return new JsonModel(['response' => 'fail']);
    }

  public function getPostsAction()
  {
      $posts = $this->getService(Constantes::MODEL_POST)->findAll();

      foreach ($posts as $key => $value) {
        $postes[$key] = $value->getArrayCopy();
        foreach ($value->commentsPost as $k => $val){
          $comments[$k]             = $val->getArrayCopy();
          $comments[$k]['postsId']  = $val->postsId->id;
        }
        $postes[$key]['commentsPost'] = $comments;
        $comments = null;
      }

      return new JsonModel($postes);
  }
}
