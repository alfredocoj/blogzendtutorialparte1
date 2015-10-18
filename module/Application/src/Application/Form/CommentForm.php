<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

class Commentform extends Form
{
    protected $inputFilter;

    public function __construct()
    {
        parent::__construct('comment');
        $this->setUseInputFilterDefaults(false); //Corrige erro do select.
        $this->setAttributes([
                'method' => 'post',
                'class'  => 'form-horizontal',
                'action' => '/admin/comments/save'
        ]);
        
        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $id          = new Element\Hidden('id');
        $postsId     = new Element\Select('postsId');
        $description = new Element\Text('description');
        $name        = new Element\Text('name');
        $email       = new Element\Email('email');
        $webpage     = new Element\Text('webpage');
        $commentDate = new Element\Hidden('commentDate');
        $submit      = new Element\Submit('submit');

        $description->setName('description')
                    ->setAttribute('placeholder', 'Digite o seu comentário')
                    ->setLabel('Comentário')
                    ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $postsId->setName('postsId')
                 ->setLabel('Post')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'))
                 ->setEmptyOption('Escolha um post');

        $name->setName('name')
             ->setAttribute('placeholder', 'Nome')
             ->setLabel('Nome')
             ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $email->setName('email')
              ->setAttribute('placeholder', 'E-mail')
              ->setLabel('E-mail')
              ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $webpage->setName('webpage')
                ->setAttribute('placeholder', 'Web page')
                ->setLabel('Web page')
                ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info');

        $this->add($id)
             ->add($postsId)
             ->add($description)
             ->add($name)
             ->add($email)
             ->add($commentDate)
             ->add($webpage)
             ->add($submit);
    }

    //Retorna um input filter de validação dos campos.
    //@return object O input filter.
    //
    public function addInputFilter()
    {
        if (is_null($this->inputFilter)) {
            $this->inputFilter = new InputFilter();
            $factory           = new InputFactory();

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => false,
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'postsId',
                'required' => true,
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'description',
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
                            'min' => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'name',
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
                            'min' => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'email',
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
                            'min' => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'webpage',
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
                            'min' => 1,
                        ),
                    ),
                ),
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'commentDate',
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
                            'min' => 1,
                        ),
                    ),
                ),
            )));

        }

        $this->setInputFilter($this->inputFilter);
    }
}
