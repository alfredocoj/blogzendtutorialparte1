<?php
namespace Admin\Model;

use Core\Model\BaseModel;

class RecursoModel extends BaseModel
{
    public function __construct()
    {
        $this->setEntity('Admin\Entity\Recurso');
    }

    /**
     * Obtém os recursos, associados aos módulos e as respectivas categorias.
     *
     * @return object Os recursos encontrados.
     *
     */
    public function getRecursos()
    {
        $repository = $this->getDbalConnection();
        $sql = "SELECT
        			r.rcs_id,
        			r.rcs_nome,
        			r.rcs_descricao,
        			m.mod_nome,
        			cr.ctr_nome,
        			r.rcs_ordem
        		FROM
        			seg_recursos r
                	LEFT JOIN seg_modulos m ON m.mod_id = r.rcs_mod_id
                	LEFT JOIN seg_categorias_recursos cr ON cr.ctr_id = r.rcs_ctr_id";

        return $repository->executeQuery($sql)->fetchAll(\PDO::FETCH_CLASS);
    }
}
