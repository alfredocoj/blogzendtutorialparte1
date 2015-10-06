<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\CategoriaRecurso")
 * @ORM\Entity
 * @ORM\Table(name="seg_categorias_recursos")
 * @property int $ctr_id
 * @property string $ctr_nome
 * @property string $ctr_descricao
 * @property string $ctr_icone
 * @property int $ctr_ordem
 * @property boolean $ctr_ordem
 */
class CategoriaRecurso
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ctr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_descricao;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_icone;

    /**
     * @ORM\Column(type="integer")
     */
    protected $ctr_ordem;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $ctr_visivel;

    public function __get($property)
    {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed  $value
     */
    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->ctr_id        = (isset($data['ctr_id'])) ? $data['ctr_id'] : null;
        $this->ctr_nome      = (isset($data['ctr_nome'])) ? $data['ctr_nome'] : null;
        $this->ctr_descricao = (isset($data['ctr_descricao'])) ? $data['ctr_descricao'] : null;
        $this->ctr_icone     = (isset($data['ctr_icone'])) ? $data['ctr_icone'] : null;
        $this->ctr_ordem     = (isset($data['ctr_ordem'])) ? $data['ctr_ordem'] : null;
        $this->ctr_visivel     = (isset($data['ctr_visivel'])) ? $data['ctr_visivel'] : null;
    }

}
