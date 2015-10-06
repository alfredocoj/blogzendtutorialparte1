<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Zend\Crypt\Password\Bcrypt;

use Core\Util\Format;
use Core\Util\MenuBarButton;
use Core\Util\Constantes;
use Admin\Form\UsuarioForm;
use Admin\Entity\Usuario;

use stdClass;

class UsuariosController extends ActionController
{
    protected $menuBar = array();

    public function indexAction()
    {
        $usuarios = $this->getService(Constantes::MODEL_USUARIO)->getAllUsers();

        $novo = new MenuBarButton();
        $novo->setName('Novo')
             ->setAction('/admin/usuarios/create')
             ->setIcon('glyphicon glyphicon-plus')
             ->setStyle('btn btn-success');

        array_push($this->menuBar, $novo);

        $permissao = new stdClass;
        $permissao->create           = $this->getService(Constantes::MODEL_AUTHORIZATION)->grantAccess('admin', 'usuarios', 'create', false);
        $permissao->update           = $this->getService(Constantes::MODEL_AUTHORIZATION)->grantAccess('admin', 'usuarios', 'update', false);
        $permissao->delete           = $this->getService(Constantes::MODEL_AUTHORIZATION)->grantAccess('admin', 'usuarios', 'delete', false);

        return new ViewModel(
            array(
                'menuButtons' => $this->menuBar,
                'usuarios'    => $usuarios,
                'permissao'   => $permissao,
            )
        );
    }
    public function createAction()
    {
        $form = new UsuarioForm;

        $request = $this->getRequest();

        if ($request->isPost()) {
            $usuario = new Usuario();
            $data    = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {
                $usuario->exchangeArray($form->getData());

                $bcrypt            = new Bcrypt();
                $usuario->usrSenha = $bcrypt->create($usuario->usrSenha);

                $this->getService(Constantes::MODEL_USUARIO)->save($usuario);
                $this->flashMessenger()->setNamespace('success')->addMessage('Usuário criado com sucesso.');
                return $this->redirect()->toUrl('/admin/usuarios/index');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Usuário não criado. Dados inválidos');
            }
        }

        return new ViewModel(array(
            'form' => $form
        ));
    }
    public function updateAction()
    {
        $id         = (int) $this->params()->fromRoute('id');
        $repository = $this->getEntityManager();
        $request    = $this->getRequest();
        $form       = new UsuarioForm();

        //Tornando opcional o campo de senha, pois o usuário não poderá editar sua senha de
        //maneira convencional.
        $form->getInputFilter()->get('usrSenha')->setRequired(false);
        $form->getInputFilter()->get('usrSenha')->setAllowEmpty(true);

        $form->setAttribute('action', '/admin/usuarios/update');

        // try get method
        if ($id) {
            $usuario = $this->getService(Constantes::MODEL_USUARIO)->getById($id);

            if (!$usuario) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Registro não encontrado.');
                return $this->redirect()->toUrl('/admin/usuarios');
            } else {
                $form->setData($usuario->getArrayCopy());
            }
        } else if ($request->isPost()) { // try post method
            $usuario = new Usuario();
            $data    = $request->getPost();

            $form->setData($data);

            if ($form->isValid()) {
                $usuario->exchangeArray($form->getData());

                //Populando o valor com a senha, para que a mesma não seja perdida.
                $userDB             = $this->getService(Constantes::MODEL_USUARIO)->getById($usuario->usrId);
                $usuario->usrSenha  = $userDB->usrSenha;

                $this->getService(Constantes::MODEL_USUARIO)->update($usuario, 'usrId');
                $this->flashMessenger()->setNamespace('success')->addMessage('Objetivo atualizado com sucesso.');
                return $this->redirect()->toUrl('/admin/usuarios/index');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Dados inválidos.');
            }
        } else {
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
            return $this->redirect()->toUrl('/admin/usuarios/index');
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
            $objetivoDB = $this->getService(Constantes::MODEL_USUARIO)->getById($id);

            if (!$objetivoDB) {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Você não tem permissão para acessar os dados desse objetivo!');
                return $this->redirect()->toUrl('/admin/usuarios/index');
            }

            if ($this->getService(Constantes::MODEL_USUARIO)->removeUser($id)) {
                $this->flashMessenger()->setNamespace('success')->addMessage('Exclusão do objetivo executada com sucesso.');
            } else {
                $this->flashMessenger()->setNamespace('danger')->addMessage('Aconteceu um erro ao executar esta operação.');
            }

            return $this->redirect()->toUrl('/admin/usuarios/index');
        }
        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal.');
        return $this->redirect()->toUrl('/admin/usuarios/index');
    }
}
