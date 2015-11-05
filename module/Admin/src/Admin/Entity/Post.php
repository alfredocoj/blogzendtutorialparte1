<?php

namespace Admin\Entity;


class Post
{

    /**
     * Nome da tabela. Campo obrigatório
     * @var string
     */
    protected $tableName ='posts';

	protected $id;


	protected $title;


	protected $description;


	protected $postDate;

    /**
     * Primary Key field name
     *
     * @var string
     */
    protected $primaryKeyField = 'id';

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

    /**
     * Return all entity data in array format
     *
     * @return array
     */
    public function getData()
    {
        $data = get_object_vars($this);
        unset($data['tableName']);
        return array_filter($data);
    }

     public function getTableName()
    {
        return $this->tableName;
    }
}
