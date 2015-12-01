<?php

namespace BlogParte1\Entity;
use Core\Entity\Entity;
use Doctrine\ORM\Mapping as ORM; //Classe que mapeia as anotações do Doctrine.

/**
 * @ORM\Entity(repositoryClass="BlogParte1\Entity\Post")
 * @ORM\Entity
 * @ORM\Table(name="posts")
*/
class Post extends Entity
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

    // métodos Getters

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }

    public function getCommentsPost()
    {
        return $this->commentsPost;
    }

    // métodos Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setPostDate($postDate)
    {
        $this->postDate = $postDate;
    }

    public function setCommentsPost($commentsPost)
    {
        $this->commentsPost = $commentsPost;
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

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
}
