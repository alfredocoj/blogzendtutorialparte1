<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

use Admin\Form\UsuarioForm;
use Admin\Entity\Usuario;

use stdClass;

class UsersController extends ActionController
{

    public function indexAction()
    {
        return new ViewModel(
            array(
                'users'    => $this->getTable('Admin\Entity\Usuario')->fetchAll()->toArray()
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
                $data['password'] = md5($data['password']);
                $usuario->exchangeArray($data);
                $saved =  $this->getTable('Admin\Entity\Usuario')->save($usuario);
                return $this->redirect()->toUrl('/admin/users/index');
            }
        }
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $usuario = $this->getTable('Admin\Entity\Usuario')->get($id);
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

        $this->getTable('Admin\Entity\Usuario')->delete($id);
        return $this->redirect()->toUrl('/admin/users/index');
    }
}
