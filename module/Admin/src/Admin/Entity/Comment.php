<?php

namespace Admin\Entity;


class Comment
{

    /** Nome da tabela. Campo obrigatório
     *
     * @var string
     *
     */
    protected $tableName ='comments';

    /**
     * Primary Key
     *
     * @var int
     */
	protected $id;

    /**
     * Forecasty Key
     *
     * @var int
     */
	protected $postsId;

    /**
     *
     * @var string
     */
	protected $description;

    /**
     *
     * @var string
     */
	protected $name;

    /**
     *
     * @var string
     */
	protected $email;

    /**
     *
     * @var string
     */
	protected $webpage;

    /**
     *
     * @var string
    */
	protected $commentDate;

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

    /**
     * Set all entity data based in an array with data
     *
     * @param array $data
     * @return void
     */
    public function setData($data)
    {
        foreach($data as $key => $value) {
            $this->__set($key, $value);
        }
    }

    /**
     * Return all entity data in array format
     *
     * @return array
     */
    public function getData()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);
        unset($data['tableName']);
        unset($data['primaryKeyField']);
        return array_filter($data);
    }

    public function getTableName()
    {
        return $this->tableName;
    }
}
