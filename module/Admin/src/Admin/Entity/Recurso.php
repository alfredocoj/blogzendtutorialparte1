<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Recurso")
 * @ORM\Entity
 * @ORM\Table(name="seg_recursos")
 * @property int $rcs_id
 * @property int $rcs_mod_id
 * @property int $rcs_ctr_id
 * @property string $rcs_nome
 * @property string $rcs_descricao
 * @property string $rcs_icone
 * @property string $rcs_ativo
 * @property int $rcs_ordem
 */
class Recurso
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $rcs_id;

    /**
     * @ORM\ManyToOne(targetEntity="Modulo")
     * @ORM\JoinColumn(name="rcs_mod_id", referencedColumnName="mod_id")
     **/
    protected $rcs_mod_id;

    /**
     * @ORM\ManyToOne(targetEntity="CategoriaRecurso")
     * @ORM\JoinColumn(name="rcs_ctr_id", referencedColumnName="ctr_id")
     **/
    protected $rcs_ctr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_descricao;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_icone;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_ativo;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rcs_ordem;

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
        $this->rcs_id        = (isset($data['rcs_id'])) ? $data['rcs_id'] : 0;
        $this->rcs_mod_id    = (isset($data['rcs_mod_id'])) ? $data['rcs_mod_id'] : 0;
        $this->rcs_ctr_id    = (isset($data['rcs_ctr_id'])) ? $data['rcs_ctr_id'] : 0;
        $this->rcs_nome      = (isset($data['rcs_nome'])) ? $data['rcs_nome'] : null;
        $this->rcs_descricao = (isset($data['rcs_descricao'])) ? $data['rcs_descricao'] : null;
        $this->rcs_icone     = (isset($data['rcs_icone'])) ? $data['rcs_icone'] : null;
        $this->rcs_ativo     = (isset($data['rcs_ativo'])) ? $data['rcs_ativo'] : 0;
        $this->rcs_ordem     = (isset($data['rcs_ordem'])) ? $data['rcs_ordem'] : null;
    }

}
