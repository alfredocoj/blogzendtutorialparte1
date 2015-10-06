<?php

namespace Admin\Model;

use Core\Model\BaseModel;
use Core\Util\LogSystem;

class UsuarioModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\Usuario');
    }

    /**
     * Obtém as permissões a partir de um dado módulo e um dado usuário.
     *
     * @param int $modId O id do Módulo.
     * @param int $usrId O id do usuário.
     *
     * @return object as permissões encontradas.
     *
     */
    public function getPermissoes($modId, $usrId)
    {
        $repository = $this->getDbalConnection();

        $sql = "SELECT DISTINCT
                    m.mod_nome,
                    cr.ctr_nome,
                    cr.ctr_icone,
                    cr.ctr_ordem,
                    r.rcs_descricao,
                    r.rcs_nome,
                    r.rcs_ordem
				FROM
					seg_usuarios                       AS u
					INNER JOIN seg_perfis_usuarios     AS pu ON u.usr_id      = pu.pru_usr_id
					INNER JOIN seg_perfis              AS p  ON pu.pru_prf_id = p.prf_id
					INNER JOIN seg_modulos             AS m  ON m.mod_id      = p.prf_mod_id
					INNER JOIN seg_perfis_permissoes   AS pp ON pp.prp_prf_id = p.prf_id
					INNER JOIN seg_permissoes          AS pm ON pm.prm_id     = pp.prp_prm_id
					INNER JOIN seg_recursos            AS r  ON r.rcs_id      = pm.prm_rcs_id
					INNER JOIN seg_categorias_recursos AS cr ON cr.ctr_id     = r.rcs_ctr_id
				WHERE
					m.mod_nome         = ?
                    AND pm.prm_nome    = ?
                    AND u.usr_id       = ?
                    AND cr.ctr_visivel = 1
				ORDER BY
					ctr_ordem, rcs_ordem";

        $data = array($modId,'index',$usrId);

        $permissao = $repository->executeQuery($sql, $data)->fetchAll(\PDO::FETCH_CLASS);

        return $permissao;
    }

    /**
     * Obtém o usuário a partir do nome.
     *
     * @param string $usrNome O nome do usuário.
     *
     * @return object O usuário obtido.
     *
     */
    public function getUsuarioByNome($usrNome)
    {
        $repository = $this->getDbalConnection();

        $sql = "SELECT
                    *
                FROM
                    seg_usuarios u
                WHERE
                    u.usr_nome like '?%'";

        $objetivos = $repository->executeQuery($sql, array($usrNome))->fetchAll(\PDO::FETCH_CLASS);
        return $objetivos;
    }

    /**
     * Retorna um usuário caso ele esteja ativo ou null caso contrário ou não encontrado.
     *
     * @param int $idUsuario O id do usuário.
     *
     * @return mixed O usuário ou null.
     */
    public function getUsuarioAtivo($idUsuario)
    {
        $conn = $this->getDbalConnection();
        $sql = "SELECT
                    usr_id,
                    usr_nome,
                    usr_email,
                    usr_senha
                FROM
                    seg_usuarios
                WHERE
                    usr_usuario   = ?
                    AND usr_ativo = 1";
        $user = $conn->executeQuery($sql, array($idUsuario))->fetchAll(\PDO::FETCH_CLASS);
        $user = !empty($user) ? current($user) : null;
        return $user;
    }

    /**
     * Obtem todos os usuários que estão ativos.
     *
     * @return object todos os usuários obtidos.
     *
     */
    public function getAllUsers()
    {
        $conn = $this->getDbalConnection();
        $sql = "SELECT
                    usr_id          AS usrId,
                    usr_nome        AS usrNome,
                    usr_email       AS usrEmail,
                    usr_telefone    AS usrTelefone,
                    usr_usuario     AS usrUsuario
                    FROM seg_usuarios
                    WHERE usr_ativo = 1
                    ORDER BY usr_nome";
        return $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Apaga um usuário do banco de dados.
     *
     * @param int $idUsuario O id do usuário.
     *
     * @return boolean Uma flag indicando o sucesso ou fracasso da operação.
     *
     */
    public function removeUser($idUsuario)
    {
        try {
            $sql = "UPDATE
                        seg_usuarios
                    SET
                        usr_ativo = 0
                    WHERE
                        usr_id = ?";
            $repository = $this->getDbalConnection();
            $repository->executeQuery($sql, [$idUsuario]);
            return true;
        } catch (\Doctrine\DBAL\DBALException $e) {
            LogSystem::getInstance("logUsuario.log")->err(
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
