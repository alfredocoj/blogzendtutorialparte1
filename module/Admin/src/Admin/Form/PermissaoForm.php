<?php
namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;

class PermissaoForm extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        // solucao do problema do campo do tipo select
        $this->setUseInputFilterDefaults(false);

        parent::__construct('novaPermissao');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/permissoes/create');

        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        $prm_id = new Element\Hidden('prm_id');

        $prm_modulo = new Element\Select('prm_modulo');
        $prm_modulo->setName('prm_modulo')
                 ->setAttribute('placeholder', 'Módulo do recurso')
                 ->setAttribute('id', 'prm_modulo')
                 ->setLabel('Módulo do recurso')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha um módulo');

        $prm_rcs_id = new Element\Select('prm_rcs_id');
        $prm_rcs_id->setName('prm_rcs_id')
                 ->setAttribute('placeholder', 'Recurso da permissão')
                 ->setAttribute('id', 'prm_rcs_id')
                 ->setLabel('Recurso da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha um recurso');

        $prm_nome = new Element\Text('prm_nome');
        $prm_nome->setName('prm_nome')
                 ->setAttribute('placeholder', 'Nome da Permissão')
                 ->setLabel('Nome da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $prm_descricao = new Element\Text('prm_descricao');
        $prm_descricao->setName('prm_descricao')
                 ->setAttribute('placeholder', 'Descrição da Permissão')
                 ->setLabel('Descrição da Permissão')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($prm_id)
             ->add($prm_modulo)
             ->add($prm_rcs_id)
             ->add($prm_nome)
             ->add($prm_descricao)
             ->add($submit);
    }

    public function addInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            // foi necessario adicionar por causa da configuracaod o form
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prm_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prm_rcs_id',
                'required' => true
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'prm_nome',
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
                'name'     => 'prm_descricao',
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
