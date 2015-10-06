<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PerfilForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novoPerfil');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/perfis/create');

        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements() {
        $prf_id = new Element\Hidden('prf_id');

        $prf_mod_id = new Element\Select('prf_mod_id');
        $prf_mod_id->setName('prf_mod_id')
                 ->setAttribute('placeholder', 'Módulo do perfil')
                 ->setLabel('Módulo do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $prf_nome = new Element\Text('prf_nome');
        $prf_nome->setName('prf_nome')
                 ->setAttribute('placeholder', 'Nome do perfil')
                 ->setLabel('Nome do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $prf_descricao = new Element\Text('prf_descricao');
        $prf_descricao->setName('prf_descricao')
                 ->setAttribute('placeholder', 'Descrição do perfil')
                 ->setLabel('Descrição do perfil')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($prf_id)
             ->add($prf_mod_id)
             ->add($prf_nome)
             ->add($prf_descricao)
             ->add($submit);
    }

    public function addInputFilter() {

        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory = new InputFactory();

            // foi necessario adicionar por causa da configuracaod o form
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_mod_id',
                'required' => true
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_nome',
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
                'name'     => 'prf_descricao',
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

            $this->inputFilter = $inputFilter;
        }

        $this->setInputFilter($this->inputFilter);
    }
}
