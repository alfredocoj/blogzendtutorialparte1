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
        $this->setUseInputFilterDefaults(false);
        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $this->setAttributes(array('method' => 'post',
                                   'class'  => 'form-horizontal',
                                   'action' => '/admin/users/save'
                                  ));

        $usrId = new Element\Hidden('usr_id');

        $name = new Element\Text('name');
        $name->setName('name')
                 ->setAttribute('placeholder', 'Nome do usuário')
                 ->setLabel('Nome do usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $username = new Element\Text('username');
        $username->setName('username')
                 ->setAttributes(array( 'id' => 'username', 'placeholder' => 'Usuário' ))
                 ->setLabel('Usuário')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $password = new Element\Password('password');
        $password->setName('password')
                 ->setAttributes(array( 'id' => 'password', 'placeholder' => 'Senha' ))
                 ->setLabel('Senha')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $role = new Element\Select('role');
        $role->setName('role')
             ->setLabel('Perfil de usuário')
             ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
             ->setValueOptions(array(
                         '' => 'Escolha um perfil',
                         'admin' => 'Administrador',
                         'redator' => 'Redator'
                 ));

        $valid = new Element\Checkbox('valid');
        $valid->setName('valid')
                 ->setLabel('Ativar usuário')
                 ->setLabelAttributes(array('class'=>'lbl'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-primary');

        $this->add($usrId)
             ->add($name)
             ->add($username)
             ->add($password)
             ->add($role)
             ->add($valid)
             ->add($submit);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $factory     = new InputFactory();

        $inputFilter->add($factory->createInput(array(
            'name'     => 'usr_id',
            'required' => true,
            'filters'  => array(
                array('name' => 'Int'),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'username',
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
                        'max'      => 50,
                    ),
                ),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'password',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'name',
            'required' => true,
            'filters'  => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'valid',
            'required' => true,
            'filters'  => array(
                array('name' => 'Int'),
            ),
        )));

        $inputFilter->add($factory->createInput(array(
            'name'     => 'role',
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
                        'max'      => 20,
                    ),
                ),
            ),
        )));

        $this->setInputFilter($inputFilter);
    }
}
