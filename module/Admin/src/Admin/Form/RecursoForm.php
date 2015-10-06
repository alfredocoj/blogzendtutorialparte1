<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class RecursoForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoRecurso');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/recursos/create');

        $this->addElements();
        $this->addInputFilter();

    }

    public function addInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            // foi necessario adicionar por causa da configuracaod o form
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_mod_id',
                'required' => true
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_ctr_id',
                'required' => true
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_nome',
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
                'name'     => 'rcs_descricao',
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
                'name'     => 'rcs_icone',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_ativo',
                'required' => false
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_ordem',
                'required' => false
            )));

            $this->inputFilter = $inputFilter;
        }

        $this->setInputFilter( $this->inputFilter );
    }

    public function addElements() {
        $rcs_id = new Element\Hidden('rcs_id');

        $rcs_mod_id = new Element\Select('rcs_mod_id');
        $rcs_mod_id->setName('rcs_mod_id')
                 ->setAttribute('placeholder', 'Módulo do recurso')
                 ->setLabel('Módulo do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $rcs_ctr_id = new Element\Select('rcs_ctr_id');
        $rcs_ctr_id->setName('rcs_ctr_id')
                 ->setAttribute('placeholder', 'Categoria do recurso')
                 ->setLabel('Categoria do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha uma categoria');

        $rcs_nome = new Element\Text('rcs_nome');
        $rcs_nome->setName('rcs_nome')
                 ->setAttribute('placeholder', 'Nome do recurso')
                 ->setLabel('Nome')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $rcs_descricao = new Element\Text('rcs_descricao');
        $rcs_descricao->setName('rcs_descricao')
                 ->setAttribute('placeholder', 'Descrição do recurso')
                 ->setLabel('Descrição')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $rcs_icone = new Element\Text('rcs_icone');
        $rcs_icone->setName('rcs_icone')
                 ->setAttribute('placeholder', 'Ícone do recurso')
                 ->setLabel('Ícone')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $rcs_ordem = new Element\Text('rcs_ordem');
        $rcs_ordem->setName('rcs_ordem')
                 ->setAttribute('placeholder', 'Ordem')
                 ->setLabel('Ordem')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $rcs_ativo = new Element\Checkbox('rcs_ativo');
        $rcs_ativo->setName('rcs_ativo')
                 ->setLabel('Ativo?')
                 ->setLabelAttributes(array('class'=>'col-sm-2 lbl'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($rcs_id)
             ->add($rcs_mod_id)
             ->add($rcs_ctr_id)
             ->add($rcs_nome)
             ->add($rcs_descricao)
             ->add($rcs_icone)
             ->add($rcs_ordem)
             ->add($rcs_ativo)
             ->add($submit);
    }
}
