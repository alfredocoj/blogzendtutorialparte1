<?php

namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 * Determinando que a classe representa um repositório.
 * @ORM\Entity(repositoryClass="Admin\Entity\Comment")
 * Definindo que essa classe representa uma entidade.
 * @ORM\Entity
 *
 * Definindo o nome da tabela que esta classe representa.
 * @ORM\Table(name="comments")
 */
class Comment
{
	/**
	 * Relacionando os atributos da tabela com os atributos da classe.
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(name="id",type="integer")
	 */
	protected $id;

	/**
	 * Este campo é uma relação muitos-para-um. Na tabela "um", deve haver um atributo que
	 * represente a relação.
	 * @ORM\ManyToOne(targetEntity="Post", inversedBy="commentsPost")
	 * @ORM\JoinColumn(name="posts_id", referencedColumnName="id")
	*/
	protected $postsId;

	/**
	 * @ORM\Column(name="description",type="string")
	 */
	protected $description;

	/**
	 * @ORM\Column(name="name",type="string")
	 */
	protected $name;

	/**
	 * @ORM\Column(name="email",type="string")
	 */
	protected $email;

	/**
	 * @ORM\Column(name="webpage",type="string")
	 */
	protected $webpage;

	/**
	 * @ORM\Column(name="comment_date",type="string")
	 */
	protected $commentDate;

	public function getId() {
        return 'id';
    }

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
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
     * @param mixed $value
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
     * Carregando os valores passados pelo usuário no objeto a ser salvo no banco.
     *
     * @param  mixed $data Os dados recebidos do usuário.
     * @return void
     */
    public function exchangeArray( array $values )
    {

       foreach( $this as $key => $value )
            if( isset( $values[$key] ) )
                $this->$key = $values[ $key ];
    }

}
