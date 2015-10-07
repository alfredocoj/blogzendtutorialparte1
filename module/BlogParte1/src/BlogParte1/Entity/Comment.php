<?php

namespace BlogParte1\Entity;
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

    //  métodos Getters

    public function getId()
    {
        return $this->id;
    }

    public function getPostId()
    {
        return $this->postId;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getWebpage()
    {
        return $this->webpage;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    // métodos Setters

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPostId($postId)
    {
        $this->postId = $postId;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setWebPage($webpage)
    {
        $this->webpage = $webpage;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }
}
