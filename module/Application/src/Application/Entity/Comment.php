<?php
namespace Application\Entity;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Core\Entity\Entity;

/**
 * Entidade Comment
 * 
 * @category Application
 * @package Entity
 */
class Comment extends Entity
{
    /**
     * Nome da tabela. Campo obrigatório
     * @var string
     */
    protected $tableName ='comments';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var int
     */
    protected $post_id;

    /**
     * @var string
     */
    protected $description;
    
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $webpage;

    /**
     * @var datetime
     */
    protected $comment_date;

}