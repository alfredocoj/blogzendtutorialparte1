<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;


class ModuloForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('novoModulo');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/modulos/create');

        $this->addInputFilter();
        $this->addElements();
    }

    public function addInputFilter() {
        if (!$this->inputFilter) {
            $this->inputFilter = new InputFilter();

            $factory = new InputFactory();

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'mod_id',
                'required' => false,
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'mod_nome',
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
                            'min'      => 1,
                            'max'      => 150,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'mod_descricao',
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
                            'min'      => 1,
                            'max'      => 150,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'mod_icone',
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
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'mod_ativo',
                'required' => false,
            )));
        }

         $this->setInputFilter($this->inputFilter);
    }

    public function addElements()
    {
        $mod_id = new Element\Hidden('mod_id');

        $mod_nome = new Element\Text('mod_nome');
        $mod_nome->setName('mod_nome')
                 ->setAttribute('placeholder', 'Nome do módulo')
                 ->setLabel('Nome')
                 ->setLabelAttributes(array('class' => 'col-sm-2 control-label'));

        $mod_descricao = new Element\Text('mod_descricao');
        $mod_descricao->setName('mod_descricao')
                 ->setAttribute('placeholder', 'Descrição do módulo')
                 ->setLabel('Descrição')
                 ->setLabelAttributes(array('class' => 'col-sm-2 control-label'));

        $mod_icone = new Element\Text('mod_icone');
        $mod_icone->setName('mod_icone')
                 ->setAttribute('placeholder', 'Ícone do módulo')
                 ->setLabel('Ícone')
                 ->setLabelAttributes(array('class' => 'col-sm-2 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($mod_id)
             ->add($mod_nome)
             ->add($mod_descricao)
             ->add($mod_icone)
             ->add($submit);
    }
}
