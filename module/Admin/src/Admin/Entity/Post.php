<?php

namespace Admin\Entity;


class Post
{

	protected $id;


	protected $title;


	protected $description;


	protected $postDate;


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
