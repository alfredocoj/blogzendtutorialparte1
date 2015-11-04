<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

use Admin\Form\UsuarioForm;
use Admin\Entity\Usuario;

use stdClass;

class UsuariosController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel(
            array(
                'usuarios'    => $this->getTable('Application\Entity\Usuario')->fetchAll()->toArray()
            )
        );
    }

    /**
     * Cria ou edita um post
     * @return void
     */
    public function saveAction()
    {
        $form = new UsuarioForm();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $usuario = new Usuario;
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $data = $form->getData();
                unset($data['submit']);
                $usuario->setData($data);

                $saved =  $this->getTable('Application\Entity\Usuario')->save($usuario);
                return $this->redirect()->toUrl('/admin/usuario/index');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $usuario = $this->getTable('Application\Entity\Usuario')->get($id);
            $form->bind($usuario);
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
        if ($id == 0) {
            throw new \Exception("Código obrigatório");
        }

        $this->getTable('Application\Entity\Usuario')->delete($id);
        return $this->redirect()->toUrl('/admin/usuario/index');
    }
}
