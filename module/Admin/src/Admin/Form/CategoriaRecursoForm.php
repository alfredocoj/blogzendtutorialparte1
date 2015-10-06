<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class CategoriaRecursoForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('novaCategoriaRecurso');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/categoriasrecursos/create');

        $this->addElements();

    }

    public function addElements() {
        $ctr_id = new Element\Hidden('ctr_id');

        $ctr_nome = new Element\Text('ctr_nome');
        $ctr_nome->setName('ctr_nome')
                 ->setAttribute('placeholder', 'Nome')
                 ->setLabel('Nome')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $ctr_descricao = new Element\Text('ctr_descricao');
        $ctr_descricao->setName('ctr_descricao')
                 ->setAttribute('placeholder', 'Descrição')
                 ->setLabel('Descrição')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $ctr_icone = new Element\Text('ctr_icone');
        $ctr_icone->setName('ctr_icone')
                 ->setAttribute('placeholder', 'Ícone')
                 ->setLabel('Ícone')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $ctr_ordem = new Element\Text('ctr_ordem');
        $ctr_ordem->setName('ctr_ordem')
                 ->setAttribute('placeholder', 'Ordem')
                 ->setLabel('Ordem')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $ctr_visivel = new Element\Checkbox('ctr_visivel');
        $ctr_visivel->setName('ctr_visivel')
                 ->setLabel('Visível')
                 ->setLabelAttributes(array('class'=>'col-sm-2 lbl'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($ctr_id)
             ->add($ctr_nome)
             ->add($ctr_descricao)
             ->add($ctr_icone)
             ->add($ctr_ordem)
             ->add($ctr_visivel)
             ->add($submit);
    }

    public function addInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ctr_nome',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ctr_descricao',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ctr_icone',
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

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ctr_ordem',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'ctr_visivel',
                'required' => false
            )));

            $this->inputFilter = $inputFilter;
        }

        $this->setInputFilter($this->inputFilter);
    }
}
