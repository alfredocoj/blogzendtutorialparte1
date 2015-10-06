<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Admin\Form\PermissaoForm;
use Admin\Entity\Permissao;

use Admin\Model\RecursoModel;

class PermissoesController extends ActionController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $permissoes = $this->getService(Constantes::MODEL_PERMISSAO)->getPermissoes();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/permissoes/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'permissoes' => $permissoes
            )
        );
    }
    public function createAction()
    {
        $form    = new PermissaoForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $permissao = new Permissao();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $permissao->exchangeArray($form->getData());
                $permissao->prm_rcs_id = $this->getService(Constantes::MODEL_RECURSO)->getById($permissao->prm_rcs_id);
                $this->getService(Constantes::MODEL_PERMISSAO)->save($permissao);

                $this->flashMessenger()->setNamespace('success')->addMessage('Permissão salva com sucesso!');

                return $this->redirect()->toUrl('/admin/permissoes');
            }
        }
        //popula o select com os modulos
        $form->get('prm_modulo')->setValueOptions($this->getService(Constantes::MODEL_MODULO)->getModuloSelect());

        return new ViewModel(
            array('form' => $form)
        );
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $request = $this->getRequest();

        $form = new PermissaoForm();
        $form->setAttribute('action', '/admin/permissoes/update');
        //popula o select com os modulos
        $form->get('prm_modulo')->setValueOptions($this->getService(Constantes::MODEL_MODULO)->getModuloSelect());

        // try get method
        if ($id) {
            $id = (int) $this->params()->fromRoute('id');

            $permissao = $this->getService(Constantes::MODEL_PERMISSAO)->getPermissaoById($id);

            if (!$permissao) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Permissão não existe!');

                return $this->redirect()->toUrl('/admin/permissoes');
            } else {
                $form->get('prm_rcs_id')->setValueOptions($this->getService(Constantes::MODEL_RECURSO)->getFindAllItemSelect('rcs_id', 'rcs_nome'));

                $form->setData($permissao);
            }
        } else if ($request->isPost()) {
            $permissao = new Permissao();
            $data      = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $permissao->exchangeArray((array) $data);

                $permissao->prm_rcs_id =  $this->getService(Constantes::MODEL_RECURSO)->getById($data['prm_rcs_id']);
                $this->getService(Constantes::MODEL_PERMISSAO)->update($permissao, 'prm_id');

                $this->flashMessenger()->setNamespace('success')->addMessage('Permissão atualizada com sucesso!');

                return $this->redirect()->toUrl('/admin/permissoes');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

            return $this->redirect()->toUrl('/admin/permissoes');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');

        // try get method
        if ($id) {
            $flag = $this->getService(Constantes::MODEL_PERMISSAO)->delete($id);

            if ($flag) {
                $this->flashMessenger()->setNamespace('success')->addMessage('Permissão excluída com sucesso!');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível excluir a permissão!');
            }

            return $this->redirect()->toUrl('/admin/permissoes');
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/permissoes');
    }
}
