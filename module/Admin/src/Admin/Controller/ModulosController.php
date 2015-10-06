<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Admin\Form\ModuloForm;
use Admin\Entity\Modulo;

class ModulosController extends ActionController
{

    protected $menuBar = array();

    public function indexAction()
    {
        $modulos = $this->getService(Constantes::MODEL_MODULO)->findAll();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/modulos/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'modulos' => $modulos
            )
        );
    }
    public function createAction()
    {
        $form = new ModuloForm;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $modulo = new Modulo();

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $modulo->exchangeArray($form->getData());
                $this->getService(Constantes::MODEL_MODULO)->save($modulo);
                $this->flashMessenger()->setNamespace('success')->addMessage('Módulo salvo com sucesso!');

                return $this->redirect()->toUrl('/admin/modulos/index');
            } else {
                $this->flashMessenger()->setNamespace('error')->addMessage('Dádos inválidos!');

                return $this->redirect()->toUrl('/admin/modulos/index');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $request = $this->getRequest();

        $form = new ModuloForm();
        $form->setAttribute('action', '/admin/modulos/update');

        // try get method
        if ($id) {
            $moduloRepository = $this->getService(Constantes::MODEL_MODULO)->getById($id);

            if (!$moduloRepository) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Módulo não existe!');

                return $this->redirect()->toUrl('/admin/modulos');
            } else {
                $form->setData($moduloRepository->getArrayCopy());
            }
        } else if ($request->isPost()) { // try post method
            $modulo = new Modulo();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $modulo->exchangeArray($form->getData());
                $this->getService(Constantes::MODEL_MODULO)->update($modulo, 'mod_id');
                $this->flashMessenger()->setNamespace('success')->addMessage('Módulo atualizado com sucesso!');

                return $this->redirect()->toUrl('/admin/modulos');
            }
        } else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

            return $this->redirect()->toUrl('/admin/modulos');
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
            $moduloRepository = $this->getService(Constantes::MODEL_MODULO)->getById($id);
            $flag = $this->getService(Constantes::MODEL_MODULO)->delete($id);

            if ($flag) {
                $this->flashMessenger()->setNamespace('success')->addMessage('Módulo excluído com sucesso!');
            } else {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir o módulo!');
            }

            return $this->redirect()->toUrl('/admin/modulos');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/modulos');
    }
}
