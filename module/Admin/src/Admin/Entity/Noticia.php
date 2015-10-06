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
 * @ORM\Entity(repositoryClass="Admin\Entity\Noticia")
 * @ORM\Entity
 * @ORM\Table(name="glo_noticias")
 * @property int $ntc_id
 * @property string $ntc_data
 * @property string $ntc_mensagem
 */
class Noticia implements InputFilterAwareInterface
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ntc_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $ntc_data;

    /**
     * @ORM\Column(type="string")
     */
    protected $ntc_mensagem;

    /**
     * Returns the Id of the object.
     *
     * @return id
     */
    public function getId()
    {
        return $this->ntc_id;
    }

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
        $this->ntc_id       = (isset($data['ntc_id'])) ? $data['ntc_id'] : null;
        $this->ntc_data     = (isset($data['ntc_data'])) ? $data['ntc_data'] : null;
        $this->ntc_mensagem = (isset($data['ntc_mensagem'])) ? $data['ntc_mensagem'] : null;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ntc_mensagem',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 10,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ntc_data',
                'required' => false,
                'validators' => array(
                    array(
                    'name' => 'Date',
                    'options' => array(
                        'format' => 'Y-m-d',
                        ),
                    ),
                    array(
                        'name' => 'NotEmpty',
                    )
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}
