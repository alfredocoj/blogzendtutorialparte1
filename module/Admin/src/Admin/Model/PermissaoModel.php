<?php

namespace Admin\Model;

use Core\Model\BaseModel;
use Core\Util\LogSystem;

class PermissaoModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\Permissao');
    }

  /**
   * Método para checar se usuário tem permissao de acesso a rota.
   *
   * @param string $modulename
   * @param string $controllerName
   * @param string $actionName
   * @param string $modulename
   * @param int $usrId
   *
   * @return mixed O resultado
   *
   */
    public function checkPermission($modulename, $controllerName, $actionName, $usrId, $modulename)
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT prm_id, prm_nome FROM seg_permissoes p
                INNER JOIN seg_perfis_permissoes pp ON prp_prm_id = prm_id
                INNER JOIN seg_recursos r ON rcs_id = prm_rcs_id
                INNER JOIN seg_modulos m ON mod_id = rcs_mod_id
                WHERE mod_nome = ?
                  AND rcs_nome = ?
                  AND prm_nome = ?
                  AND prp_prf_id = (
                    SELECT prf_id FROM seg_perfis
                    INNER JOIN seg_modulos ON mod_id = prf_mod_id
                    INNER JOIN seg_perfis_usuarios ON pru_prf_id = prf_id
                    WHERE pru_usr_id = ? AND mod_nome = ? AND r.rcs_ativo = 1
                  )";
        $data = array($modulename, $controllerName, $actionName, $usrId, $modulename);
        return $repository->executeQuery($sql, $data)->fetchAll();
    }

    /**
     * Obtém as permissões para cada recurso, de acordo com o perfil do usuário e o módulo
     * desejado.
     *
     * @param int $idPerfil O id do perfil
     * @param int $idModulo O id do módulo
     *
     * @return object As permissões do recurso.
     *
     */
    public function getRecPermissionsByPerfilIdAndModuloId($idPerfil, $idModulo)
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
                    rcs_id, rcs_nome, prm_id, prm_nome, IF(bol = 1, 1, 0) as habilitado
                FROM
                (
                    SELECT
                        rcs_id, rcs_nome, prm_id, prm_nome
                    FROM
                        seg_permissoes p
                        LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                        WHERE r.rcs_mod_id = ?
                ) as todas
                LEFT JOIN
                (
                    SELECT
                        prm_id as temp,
                        1 as bol
                    FROM
                        seg_permissoes p
                        LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                        LEFT JOIN seg_perfis_permissoes pp ON pp.prp_prm_id = p.prm_id
                        WHERE pp.prp_prf_id = ?
                ) menos ON todas.prm_id = menos.temp";
        $data = array($idModulo, $idPerfil);
        return $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Obtém as permissões do banco de dados, associadas aos recursos e módulos.
     *
     * @return object As permissões.
     *
     */
    public function getPermissoes()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
                    p.*,
                    rcs_nome,
                    mod_nome
                FROM
                    seg_permissoes p
                LEFT JOIN seg_recursos r ON r.rcs_id = p.prm_rcs_id
                LEFT JOIN seg_modulos m ON m.mod_id = r.rcs_mod_id";
        return $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);
    }


    /**
     * Obtém uma permissão através do seu id.
     *
     * @param int $id O id da permissão
     *
     * @return object A permissão encontrada.
     *
     */
    public function getPermissaoById($id)
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT r.rcs_mod_id as prm_modulo, p.* FROM seg_permissoes p
                LEFT JOIN seg_recursos r on r.rcs_id = p.prm_rcs_id
                WHERE prm_id = ?";
        $data = array($id);

        $permissao = $repository->executeQuery($sql, $data)->fetchAll();

        if ($permissao) {
            $permissao = $permissao[0];
        }

        return $permissao;
    }


  /**
   * Vincula ou desvincula permissões a perfil.
   *
   * @param int $id O id do perfil
   *
   * @param mix $permissoes
   *
   * @return boolean true caso a operação tenha ocorrido sem problemas. false em caso contrário.
   *
  */
  public function salvarPermissoesPerfil($perfilId,$permissoes)
  {
      $sql = "INSERT INTO seg_perfis_permissoes (`prp_prf_id`, `prp_prm_id`) VALUES ({$perfilId}, {$permissoes[0]})";
      for ($i=1; $i < sizeof($permissoes); $i++) {
          $sql .= ",({$perfilId}, {$permissoes[$i]})";
      }
      $sql .= ";";

      $repository = $this->getDbalConnection();

      $sqlDelete = "DELETE FROM seg_perfis_permissoes WHERE prp_prf_id = ?";
      $dataDelete = array($perfilId);
      try {
          $delete = $repository->executeQuery($sqlDelete, $dataDelete);
          $insert = $repository->executeQuery($sql);
          return true;
      } catch (\Doctrine\DBAL\DBALException $e) {
          LogSystem::getInstance('logPermissao.log')->err(
            array(
              'message' => $e.getMessages(),
              'class'   => get_class($this),
              'method'  => __FUNCTION__
            )
          );
          return false;
      }

  }
}
