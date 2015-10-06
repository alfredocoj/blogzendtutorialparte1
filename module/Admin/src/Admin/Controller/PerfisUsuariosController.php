<?php

namespace Admin\Controller;

use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;
use Core\Util\Constantes;

class PerfisUsuariosController extends ActionController
{
    public function indexAction()
    {

        $usuarios = $this->getService(Constantes::MODEL_USUARIO)->getAllUsers();

        return new ViewModel(
            array(
                'usuarios' => $usuarios
            )
        );
    }
    public function gerenciarperfisusuarioAction()
    {
        $idUsuario = (int) $this->params()->fromRoute('id');

        $usuarioPerfis = $this->getService(Constantes::MODEL_PERFIL)->getPerfilByIdUsuario($idUsuario);

        $usuario = $this->getService(Constantes::MODEL_USUARIO)->getById($idUsuario);

        $modulos = $this->getService(Constantes::MODEL_MODULO)->getRemainingModulosByIdUsuarioToSelect($idUsuario);

        return new ViewModel(
            array(
                'usuario'       => $usuario,
                'usuarioPerfis' => $usuarioPerfis,
                'modulos'       => $modulos,
            )
        );
    }
    public function deleteAction()
    {
        $idUsuario  = (int) $this->params()->fromRoute('id');
        $idPerfil   = (int) $this->params()->fromRoute('idtwo');

        // try get method
        if ($idUsuario != 0 && $idPerfil != 0) {

            if ( $this->getService(Constantes::MODEL_PERFIL)->deletePerfisUsuarios( $idUsuario, $idPerfil ) )
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil excluído com sucesso!');
            else
                $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível excluir o perfil!');

            return $this->redirect()->toUrl('/admin/perfisusuarios/gerenciarperfisusuario/' . $idUsuario);
        }

        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/perfisusuarios');
    }
    public function atribuirperfilusuarioAction()
    {
        $idUsuario = (int) $this->params()->fromRoute('id');
        $idPerfil = (int) $this->params()->fromRoute('idtwo');

        if ($idUsuario != 0 && $idPerfil != 0) {

            if ( $this->getService(Constante::MODEL_PERFIL)->atribuirPerfilUsuario( $idUsuario, $idPerfil ) )
                $this->flashMessenger()->setNamespace('success')->addMessage('Perfil Atribuído com sucesso!');
            else
                $this->flashMessenger()->setNamespace('danger')->addMessage('Não foi possível atribuir o perfil!');

            return $this->redirect()->toUrl('/admin/perfisusuarios/gerenciarperfisusuario/' . $idUsuario);
        }

        $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');

        return $this->redirect()->toUrl('/admin/perfisusuarios');
    }
}
