<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Perfil")
 * @ORM\Entity
 * @ORM\Table(name="seg_perfis")
 * @property int $prf_id
 * @property string $prf_nome
 * @property string $prf_descricao
 */
class Perfil
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $prf_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $prf_mod_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $prf_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $prf_descricao;

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
        $this->prf_id = (isset($data['prf_id'])) ? $data['prf_id'] : 0;
        $this->prf_mod_id = (isset($data['prf_mod_id'])) ? $data['prf_mod_id'] : null;
        $this->prf_nome = (isset($data['prf_nome'])) ? $data['prf_nome'] : null;
        $this->prf_descricao = (isset($data['prf_descricao'])) ? $data['prf_descricao'] : null;
    }
}
