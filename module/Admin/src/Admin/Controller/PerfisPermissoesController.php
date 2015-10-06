<?php

namespace Admin\Controller;

use Core\Util\Constantes;
use Core\Controller\ActionController;
use Zend\View\Model\ViewModel;

class PerfisPermissoesController extends ActionController
{
    public function indexAction()
    {
        $perfis = $this->getService(Constantes::MODEL_PERFIL)->getPerfis();
        return new ViewModel(
            array(
                'perfis' => $perfis
            )
        );
    }
    public function atribuirpermissoesperfilAction()
    {
        $idPerfil = (int) $this->params()->fromRoute('id');

        $perfil = $this->getService(Constantes::MODEL_PERFIL)->getPerfilModuloByIdPerfil($idPerfil);
        $perfil = current($perfil);

        $perm = $this->getService(Constantes::MODEL_PERMISSAO)->getRecPermissionsByPerfilIdAndModuloId($idPerfil,$perfil->mod_id);
        $permissoes = array();
        foreach ($perm as $key => $value) {
            if (isset($permissoes[$value->rcs_id])) {
                $permissoes[$value->rcs_id]['permissoes'][$value->prm_id] = array(
                                                                                  'prm_id' => $value->prm_id,
                                                                                  'prm_nome' => $value->prm_nome,
                                                                                  'habilitado' => $value->habilitado);
            } else {
                $permissoes[$value->rcs_id]['rcs_id']                     = $value->rcs_id;
                $permissoes[$value->rcs_id]['rcs_nome']                   = $value->rcs_nome;
                $permissoes[$value->rcs_id]['permissoes'][$value->prm_id] = array(
                                                                                  'prm_id' => $value->prm_id,
                                                                                  'prm_nome' => $value->prm_nome,
                                                                                  'habilitado' => $value->habilitado);
            }
        }

        return new ViewModel(
            array(
                'perfil'      => $perfil,
                'permissoes'  => $permissoes
            )
        );
    }
    public function salvarpermissoesperfilAction()
    {
        $request = $this->getRequest();

        if ($request->isPost()) {
            $post = $request->getPost();
            $perfilId = $post['prf_id'];
            $moduloId = $post['mod_id'];

            $permissoes = $post['permissoes'];

            if (sizeof($permissoes)) {
                $flag = $this->getService(Constantes::MODEL_PERMISSAO)->salvarPermissoesPerfil($perfilId,$permissoes);
                if ( $flag )
                    $this->flashMessenger()->setNamespace('success')->addMessage('Permissões atribuidas com sucesso!');
                else
                    $this->flashMessenger()->setNamespace('danger')->addMessage('Houve um problema nessa requisição, por favor, tente novamente!');

                return $this->redirect()->toUrl('/admin/perfispermissoes');
            }

        }
        else{
            $this->flashMessenger()->setNamespace('danger')->addMessage('Acesso ilegal!');
        }

        return $this->redirect()->toUrl('/admin/perfispermissoes');

    }
}
