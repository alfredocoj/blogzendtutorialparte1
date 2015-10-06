<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

use Core\Util\Constantes;
use Core\Util\MenuBarButton;
use Admin\Form\PerfilForm;
use Admin\Entity\Perfil;

class PerfisController extends ActionController
{
    protected $menuBar = array();

    public function indexAction()
    {

        $perfis = $this->getService(Constantes::MODEL_PERFIL)->getPerfis();
        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/perfis/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'perfis' => $perfis
            )
        );
    }

    public function createAction()
    {
        $form = new PerfilForm();
        $request = $this->getRequest();

        if ($request->isPost()) {
            $perfil = new Perfil();

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $perfil->exchangeArray($form->getData());
                $this->getService(Constantes::MODEL_PERFIL)->save($perfil);
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil salvo com sucesso!');

                return $this->redirect()->toUrl('/admin/perfis');
            }
        }

        //popula o select com os modulos
        $form->get('prf_mod_id')->setValueOptions($this->getService(Constantes::MODEL_MODULO)->getModuloSelect());

        return new ViewModel(
            array('form' => $form)
        );
    }

    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $request = $this->getRequest();

        $form = new PerfilForm();
        $form->setAttribute('action', '/admin/perfis/update');
        //popula o select com os modulos
        $form->get('prf_mod_id')->setValueOptions($this->getService(Constantes::MODEL_MODULO)->getModuloSelect());

        // try get method
        if ($id) {
            $perfilRepository = $this->getService(Constantes::MODEL_PERFIL)->getById($id);
            if (!$perfilRepository) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Perfil não existe!');

                return $this->redirect()->toUrl('/admin/perfis');
            } else {
                $form->setData($perfilRepository->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $perfil = new Perfil();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $perfil->exchangeArray($form->getData());

                $this->getService(Constantes::MODEL_PERFIL)->update($perfil,'prf_id');

                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil atualizado com sucesso!');

                return $this->redirect()->toUrl('/admin/perfis');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

            return $this->redirect()->toUrl('/admin/perfis');
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();

        // try get method
        if ($id) {
            $flag = $this->getService(Constantes::MODEL_PERFIL)->delete($id);

            if ($flag) {
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil excluído com sucesso!');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível excluir o perfil! Possívelmente, esse perfil está vinculado a algum usuário.');
            }
            return $this->redirect()->toUrl('/admin/perfis/index');
        }

        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/perfis/index');
    }
}
