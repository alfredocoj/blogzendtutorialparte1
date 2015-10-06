<?php

namespace Admin\Model;

use Core\Model\BaseModel;

class ModuloModel extends BaseModel
{

    public function __construct()
    {
        $this->setEntity('Admin\Entity\Modulo');
    }

    /**
     * Obtém os módulos associados a um determinado usuário.
     *
     * @param int $idUsuario O id do usuário.
     *
     * @return object os módulos encontrados.
     *
     */
    public function getModulosByUsuarioId($idUsuario)
    {
        $repository = $this->getDbalConnection();

        $sql = "SELECT *,p.prf_nome from seg_modulos m
                INNER JOIN seg_perfis p ON p.prf_mod_id = m.mod_id
                INNER JOIN seg_perfis_usuarios pu ON pu.pru_prf_id = p.prf_id
                WHERE m.mod_ativo = 1 AND pu.pru_usr_id = ".$idUsuario;

        $userModules = $repository->executeQuery($sql)->fetchAll();

        return $userModules;
    }

    /**
     * Obtém os módulos para popular um select desejado.
     *
     * @return array Um array de módulos.
     *
     */
    public function getModuloSelect()
    {
        $modulos = $this->findAll();
        foreach ($modulos as $key => $value) {
            $modulosSelect[$value->mod_id] = $value->mod_nome;
        }

        return $modulosSelect;
    }

    /**
     * Obtém os módulos ainda não vinculados ao usuário.
     *
     * @param int $idUsuario O id do usuário.
     *
     * @return object os módulos restantes.
     *
     */
    public function getRemainingModulosByIdUsuarioToSelect($idUsuario)
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
                      mod_id    AS id,
                      mod_nome  AS descricao
                FROM seg_modulos
                WHERE
                 mod_id NOT IN (
                    SELECT prf_mod_id
                        FROM seg_perfis
                        WHERE prf_id IN (
                            SELECT pru_prf_id
                            FROM seg_usuarios u
                            LEFT JOIN seg_perfis_usuarios pu ON pu.pru_usr_id = u.usr_id
                            WHERE u.usr_id = ?
                        )
                )";
        $data = array($idUsuario);
        return $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);
    }
}
