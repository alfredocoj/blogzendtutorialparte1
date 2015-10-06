<?php

namespace Admin\Entity;
use Doctrine\ORM\Mapping as ORM; //Classe necessária para as anotações do Doctrine.

/**
 * @ORM\Entity(repositoryClass="Admin\Entity\Post")
 * @ORM\Entity
 * @ORM\Table(name="posts")
 */

class Post
{

	/*Relacionando os atributos da tabela com os atributos da classe.*/

	/**
     * @ORM\Id
	 * @ORM\GeneratedValue(strategy="AUTO")
	 * @ORM\Column(name="id",type="integer")
     */
	protected $id;

    /**
     * @ORM\Column(name="title",type="string")
     */
	protected $title;

    /**
     * @ORM\Column(name="description",type="string")
     */
	protected $description;

    /**
     * @ORM\Column(name="post_date",type="string")
     */
	protected $postDate;

    /**
     * @ORM\OneToMany(targetEntity="Comment", mappedBy="postsId")
     */
	protected $commentsPost;

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

    public function getId() {
        return 'id';
    }

}
