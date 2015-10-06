<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Core\Util\Constantes;
use Core\Util\MenuBarButton;
use Admin\Form\CategoriaRecursoForm;
use Admin\Entity\CategoriaRecurso;

class CategoriasRecursosController extends ActionController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $categoriasRecursos = $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->findAll();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/categoriasrecursos/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn-success');

        array_push($this->menuBar, $novo);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'categoriasRecursos' => $categoriasRecursos
            )
        );
    }

    public function createAction()
    {
        $form = new CategoriaRecursoForm;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $categoriaRecurso = new CategoriaRecurso();

            $form->setData($request->getPost());

            if ($form->isValid()) {
                $categoriaRecurso->exchangeArray($form->getData());

                $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->save($categoriaRecurso);

                $this->flashMessenger()->setNamespace('success')->addMessage('Categoria salva com sucesso!');

                return $this->redirect()->toUrl('/admin/categoriasrecursos');
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

        $form = new CategoriaRecursoForm();
        $form->setAttribute('action', '/admin/categoriasrecursos/update');

        // try get method
        if ($id) {
            $categoriaRecursoRepository = $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->getById($id);

            if (!$categoriaRecursoRepository) {
                $this->flashMessenger()->setNamespace('error')->addMessage('Categoria não existe!');

                return $this->redirect()->toUrl('/admin/categoriasrecursos');
            } else {
                $form->setData($categoriaRecursoRepository->getArrayCopy());
            }
        }
        // try post method
        else if ($request->isPost()) {
            $categoriaRecurso = new CategoriaRecurso();
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $categoriaRecurso->exchangeArray($form->getData());

                $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->update($categoriaRecurso, 'ctr_id');
                $this->flashMessenger()->setNamespace('success')->addMessage('Categoria atualizada com sucesso!');

                return $this->redirect()->toUrl('/admin/categoriasrecursos');
            }
        } else {
            $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

            return $this->redirect()->toUrl('/admin/categoriasrecursos');
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
            $categoriaRecursoRepository = $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->getById($id);

            $flag = $this->getService(Constantes::MODEL_CATEGORIA_RECURSO)->delete($id);

            if ($flag) {
                $this->flashMessenger()->setNamespace('success')->addMessage('Categoria excluída com sucesso!');
            } else {
                $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir a categoria!');
            }

            return $this->redirect()->toUrl('/admin/categoriasrecursos');
        }
        $this->flashMessenger()->setNamespace('error')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/categoriasrecursos');
    }
}
