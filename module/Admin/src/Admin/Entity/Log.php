<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Log")
 * @ORM\Entity
 * @ORM\Table(name="glo_logs")
 * @property int $log_id
 * @property int $log_usr_id
 * @property string $log_modulo
 * @property string $log_entity
 * @property int $log_table
 * @property string $log_obj_old
 * @property string $log_obj_new
 * @property string $log_data_criacao
 */
class Log implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $log_id;

    /**
     * @ORM\ManyToOne(targetEntity="Usuario")
     * @ORM\JoinColumn(name="log_usr_id", referencedColumnName="usr_id")
     **/
    protected $log_usr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_action;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_modulo;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_entity;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_table;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_obj_old;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_obj_new;

    /**
     * @ORM\Column(type="string")
     */
    protected $log_data_criacao;

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
     * Populate from an array.
     *
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->log_id           = (isset($data['log_id'])) ? $data['log_id'] : null;
        $this->log_usr_id       = (isset($data['log_usr_id'])) ? $data['log_usr_id'] : null;
        $this->log_action       = (isset($data['log_action'])) ? $data['log_action'] : null;
        $this->log_modulo       = (isset($data['log_modulo'])) ? $data['log_modulo'] : null;
        $this->log_entity       = (isset($data['log_entity'])) ? $data['log_entity'] : null;
        $this->log_table        = (isset($data['log_table'])) ? $data['log_table'] : null;
        $this->log_obj_old      = (isset($data['log_obj_old'])) ? $data['log_obj_old'] : null;
        $this->log_obj_new      = (isset($data['log_obj_new'])) ? $data['log_obj_new'] : null;
        $this->log_data_criacao = (isset($data['log_data_criacao'])) ? $data['log_data_criacao'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {

    }
}
