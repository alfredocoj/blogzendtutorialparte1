<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Admin\Form\RecursoForm;
use Admin\Entity\Recurso;

class RecursosController extends ActionController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $recursos = $this->getService(Constantes::MODEL_RECURSO)->getRecursos();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/recursos/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'recursos' => $recursos
            )
        );
    }
    public function createAction()
    {
        $form = new RecursoForm;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $recurso = new Recurso();

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $recurso->exchangeArray($form->getData());

                $recurso->rcs_mod_id = $this->getService('Admin\Model\ModuloModel')->getById($recurso->rcs_mod_id);
                $recurso->rcs_ctr_id = $this->getService('Admin\Model\CategoriaRecursoModel')->getById($recurso->rcs_ctr_id);

                $this->getService('Admin\Model\RecursoModel')->save($recurso);

                $this->flashMessenger()->setNamespace('success')->addMessage('Recurso salvo com sucesso!');

                return $this->redirect()->toUrl('/admin/recursos');
            }
        }

        //popula o select com os modulos
        $form->get('rcs_mod_id')->setValueOptions($this->prepareEntityToSelect('Modulo', 'mod'));
        $form->get('rcs_ctr_id')->setValueOptions($this->prepareEntityToSelect('CategoriaRecurso', 'ctr'));

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function updateAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request = $this->getRequest();

        $form = new RecursoForm();
        $form->setAttribute('action', '/admin/recursos/update');
        //popula o select com os modulos
        $form->get('rcs_mod_id')->setValueOptions($this->prepareEntityToSelect('Modulo', 'mod'));
        $form->get('rcs_ctr_id')->setValueOptions($this->prepareEntityToSelect('CategoriaRecurso', 'ctr'));

        // try get method
        if ($id) {
            $recursoData = $this->getService('Admin\Model\RecursoModel')->getById($id);

            if (!$recursoData) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Recurso não existe!');

                return $this->redirect()->toUrl('/admin/recursos');
            } else {
                $form->setData($recursoData->getArrayCopy());

                //Obtendo os ids categoria de recurso e modulo para atribuir corretamente aos selects
                //do formulário
                $categoriaId = $recursoData->rcs_ctr_id->ctr_id;
                $moduloId    = $recursoData->rcs_mod_id->mod_id;
            }
        } else if ($request->isPost()) { // try post method
            $recurso = new Recurso();
            $data = $request->getPost();
            $form->setData($data);

            if ($form->isValid()) {
                $recurso->exchangeArray($form->getData());

                $recurso->rcs_mod_id = $this->getService('Admin\Model\ModuloModel')->getById($data['rcs_mod_id']);

                $recurso->rcs_ctr_id = $this->getService('Admin\Model\CategoriaRecursoModel')->getById($data['rcs_ctr_id']);


                $this->getService('Admin\Model\RecursoModel')->update($recurso, 'rcs_id');

                $this->flashMessenger()->setNamespace('success')->addMessage('Recurso atualizado com sucesso!');

                return $this->redirect()->toUrl('/admin/recursos');
            }
        } else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

            return $this->redirect()->toUrl('/admin/recursos');
        }

        return new ViewModel(array(
            'form' => $form,
            'categoriaId' => $categoriaId,
            'moduloId' => $moduloId
        ));
    }
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();

        // try get method
        if ($id) {
            $recursoRepository = $repository->find('Admin\Entity\Recurso', $id);

            try {
                $repository->remove($recursoRepository);
                $repository->flush();

                $this->flashMessenger()->setNamespace('success')->addMessage('Recurso excluído com sucesso!');
            } catch (\Doctrine\DBAL\DBALException $e) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir o recurso!');
            }

            return $this->redirect()->toUrl('/admin/recursos');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/recursos');
    }

    public function prepareEntityToSelect($entity, $prefix)
    {
        $id = $prefix . "_id";
        $nome = $prefix . "_nome";
        $repository = $this->getEntityManager()->getRepository("Admin\Entity\\$entity");
        $data = $repository->findAll();
        $resultData = array();

        foreach ($data as $key => $value) {
            $resultData[$value->$id] = $value->$nome;
        }

        return $resultData;
    }
}
