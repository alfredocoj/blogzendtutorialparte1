<?php

namespace Admin\Model;

use Core\Model\BaseModel;
use Core\Util\LogSystem;

class PerfilModel extends BaseModel
{

    public function __construct()
    {
        $this->setEntity('Admin\Entity\Perfil');
    }

    /**
     * Obtém o os perfis de acordo com um dado módulo.
     *
     * @param int $moduloId O id do módulo
     *
     * @return object Os perfis encontrados.
     *
     */
    public function getByModuloId($moduloId)
    {
        $repository = $this->getDbalConnection();

        $sql = "SELECT prf_id as prfId,
                       prf_nome as prfNome
                FROM seg_perfis
                WHERE prf_mod_id = ?";
        $data = array($moduloId);
        return $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Retorna os perfis cadastrados associados aos módulos.
     *
     * @return object Os perfis.
     *
     */
    public function getPerfis()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
        			p.*,
        			m.mod_nome
        		FROM
        			seg_perfis p
        			LEFT JOIN seg_modulos m on m.mod_id = p.prf_mod_id";

        $perfis = $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);
        return $perfis;
    }

    /**
     * Retorna um dado perfil associado ao respectivo módulo.
     *
     * @param int $idPerfil O id do Perfil.
     *
     * @return object O perfil associado ao módulo.
     *
     */
    public function getPerfilModuloByIdPerfil($idPerfil)
    {

        $repository = $this->getDbalConnection();
        $sql = "SELECT p.prf_id, p.prf_nome, m.mod_id, m.mod_nome FROM seg_perfis p
                LEFT JOIN seg_modulos m ON m.mod_id = p.prf_mod_id
                WHERE prf_id = ?";
        $data = array($idPerfil);
        return $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Retorna um dado perfil associado ao respectivo módulo.
     *
     * @param int $idPerfil O id do Usuário.
     *
     * @return object O perfil associado ao módulo.
     *
     */
    public function getPerfilByIdUsuario($idUsuario)
    {
        $repository = $this->getDbalConnection();

        $sql = "SELECT p.prf_id         as prfId,
                       p.prf_nome       as prfNome,
                       p.prf_descricao  as prfDescricao,
                       m.mod_nome       as modNome
                       FROM seg_perfis p
                LEFT JOIN seg_perfis_usuarios pu ON pu.pru_prf_id = p.prf_id
                LEFT JOIN seg_usuarios u ON u.usr_id = pu.pru_usr_id
                LEFT JOIN seg_modulos m ON m.mod_id = prf_mod_id
                WHERE u.usr_id = ?";
        $data = array($idUsuario);
        return $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Atribui perfil ao usuário.
     *
     * @param int $idUsuario O id do Usuário.
     *
     * @param int $idPerfil O id do Perfil.
     *
     * @return boolean True ou False.
     *
     */
    public function atribuirPerfilUsuario( $idUsuario, $idPerfil )
    {
        try {
                $sql = "INSERT INTO seg_perfis_usuarios (`pru_usr_id`, `pru_prf_id`) VALUE (?,?)";
                $data = array($idUsuario, $idPerfil);

                $repository = $this->getDbalConnection();
                $repository->executeQuery( $sql, $data );

                return true;
            } catch (\Doctrine\DBAL\DBALException $e) {
                return false;
            }
    }

     /**
     * Desvincula perfil de usuário.
     *
     * @param int $idUsuario O id do Usuário.
     *
     * @param int $idPerfil O id do Perfil.
     *
     * @return boolean True ou False.
     *
     */
    public function deletePerfisUsuarios( $idUsuario, $idPerfil )
    {
          try {
                  $sql = "DELETE FROM seg_perfis_usuarios WHERE pru_usr_id = ? AND pru_prf_id = ?";
                  $data = array($idUsuario, $idPerfil);

                  $repository = $this->getDbalConnection();
                  $repository->executeQuery($sql, $data);

                  return true;

              } catch (\Doctrine\DBAL\DBALException $e) {
                  LogSystem::getInstance("logPerfil.log")->err(
                              array(
                                        'message' => $e->getMessage(),
                                        'class'   => get_class($this),
                                        'method'  => __FUNCTION__,
                                    )
                            );

                  return false;
              }
    }

    /**
     * Deleta perfil.
     *
     * @param int $idUsuario O id do Usuário.
     *
     * @param int $idPerfil O id do Perfil.
     *
     * @return boolean True ou False.
     *
     */
    public function delete( $idPerfil )
    {
          try {

                  $repository = $this->getDbalConnection();
                  $sql = "SELECT * FROM seg_perfis_usuarios
                                  where pru_prf_id = ?";
                  $data = array( $idPerfil );

                  if ( empty( $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS) ) ) {
                      $sql = "DELETE FROM seg_perfis WHERE prf_id = ?";
                      $repository->executeQuery($sql, $data);
                      return true;
                  } else {
                      return false;
                  }

              } catch (\Doctrine\DBAL\DBALException $e) {
                  LogSystem::getInstance("logPerfil.log")->err(
                              array(
                                        'message' => $e->getMessage(),
                                        'class'   => get_class($this),
                                        'method'  => __FUNCTION__,
                                    )
                            );

                  return false;
              }
    }
}
