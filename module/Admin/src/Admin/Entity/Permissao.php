<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Permissao")
 * @ORM\Entity
 * @ORM\Table(name="seg_permissoes")
 * @property int $prm_id
 * @property int $prm_rcs_id
 * @property string $prm_nome
 * @property string $prm_descricao
 */
class Permissao
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $prm_id;

    /**
     * @ORM\ManyToOne(targetEntity="Recurso")
     * @ORM\JoinColumn(name="prm_rcs_id", referencedColumnName="rcs_id")
     **/
    protected $prm_rcs_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $prm_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $prm_descricao;

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
    public function exchangeArray(array $values )
    {
        foreach( $this as $key => $value )
            if( isset( $values[$key] ) )
                $this->$key = $values[ $key ];
    }
}
