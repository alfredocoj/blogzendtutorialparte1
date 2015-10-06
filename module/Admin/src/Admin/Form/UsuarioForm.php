<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

class UsuarioForm extends Form
{
    public function __construct()
    {
        parent::__construct('novousuario');
        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $this->setAttribute('method', 'post');
        $this->setAttribute('class','form-horizontal');
        $this->setAttribute('action', '/admin/usuarios/create');

        $usrId = new Element\Hidden('usrId');

        $usrNome = new Element\Text('usrNome');
        $usrNome->setName('usrNome')
                 ->setAttribute('placeholder', 'Nome do usuário')
                 ->setLabel('Nome do usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $usrEmail = new Element\Email('usrEmail');
        $usrEmail->setName('usrEmail')
                 ->setAttribute('placeholder', 'Email')
                 ->setLabel('Email')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $usrTelefone = new Element\Text('usrTelefone');
        $usrTelefone->setName('usrTelefone')
                 ->setAttribute('placeholder', 'Telefone')
                 ->setAttribute('id', 'usrTelefone')
                 ->setLabel('Telefone pessoal')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $usrUsuario = new Element\Text('usrUsuario');
        $usrUsuario->setName('usrUsuario')
                 ->setAttributes(array( 'id' => 'usrUsuario', 'placeholder' => 'Usuário' ))
                 ->setLabel('Usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $usrSenha = new Element\Password('usrSenha');
        $usrSenha->setName('usrSenha')
                 ->setAttributes(array( 'id' => 'usrSenha', 'placeholder' => 'Senha' ))
                 ->setLabel('Senha')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $usrAtivo = new Element\Checkbox('usrAtivo');
        $usrAtivo->setName('usrAtivo')
                 ->setLabel('Ativar usuário')
                 ->setLabelAttributes(array('class'=>'lbl'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-primary');

        $this->add($usrId)
             ->add($usrNome)
             ->add($usrEmail)
             ->add($usrTelefone)
             ->add($usrUsuario)
             ->add($usrSenha)
             ->add($usrAtivo)
             ->add($submit);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();

        $factory = new InputFactory();

        $inputFilter->add($factory->createInput(array(
            'name'     => 'usrNome',
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
            'name'     => 'usrUsuario',
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
            'name'     => 'usrSenha',
            'required' => true,
        )));

        $inputFilter->add($factory->createInput(array(
                    'name' => 'usrTelefone',
                    'required' => true,
                    'filters' => array(
                        array('name' => 'StripTags'),
                        array('name' => 'StringTrim'),
                    ),
                    'validators' => array(
                        array(
                            'name' => 'StringLength',
                            'options'       => array(
                                'encoding'  => 'UTF-8',
                                'min'       => 1,
                                'max'       => 13,
                            ),
                        ),
                    ),
        )));

        $this->setInputFilter($inputFilter);
    }
}
