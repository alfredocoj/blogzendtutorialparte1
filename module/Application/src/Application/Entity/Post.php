<?php
namespace Application\Entity;

use Core\Entity\Entity;

/**
 * Entidade Post
 * 
 * @category Application
 * @package Entity
 */
class Post extends Entity
{
    /**
     * Nome da tabela. Campo obrigatório
     * @var string
     */
    protected $tableName ='posts';

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var datetime
     */
    protected $post_date;
}
