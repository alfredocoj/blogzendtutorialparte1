<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Usuario")
 * @ORM\Entity
 * @ORM\Table(name="seg_usuarios")
 * @property int    $usrId
 * @property string $usrNome
 * @property string $usrEmail
 * @property string $usrUsuario
 * @property string $usrSenha
 * @property string $usrTelefone
 * @property bool   $usrAtivo
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="usr_id", type="integer")
     */
    protected $usrId;

    /**
     * @ORM\Column(name="usr_nome", type="string")
     */
    protected $usrNome;

    /**
     * @ORM\Column(name="usr_email", type="string")
     */
    protected $usrEmail;

    /**
     * @ORM\Column(name="usr_telefone", type="string")
     */
    protected $usrTelefone;

    /**
     * @ORM\Column(name="usr_usuario", type="string")
     */
    protected $usrUsuario;

    /**
     * @ORM\Column(name="usr_senha", type="string")
     */
    protected $usrSenha;

    /**
     * @ORM\Column(name="usr_ativo", type="boolean", columnDefinition="TINYINT DEFAULT 1 NOT NULL")
     */
    protected $usrAtivo;

    /**
     * Magic getter to expose protected properties.
     *
     * @param  string $property
     * @return mixed
     */
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
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function getId()
    {
        return 'usrId';
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function exchangeArray( array $values )
    {
        foreach( $this as $key => $value )
            if( isset( $values[$key] ) )
                $this->$key = $values[ $key ];
    }
}
