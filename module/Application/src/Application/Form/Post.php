<?php
namespace Application\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterInterface;

class Post extends Form
{
    public function __construct()
    {
        parent::__construct('post');
        $this->setAttribute('method', 'post');
        $this->setAttribute('action', '/admin/posts/save');
        
        $this->addElements();
        $this->addInputFilter();

    }

    public function addElements()
    {
        $id          = new Element\Hidden('id');
        $title       = new Element\Text('title');
        $description = new Element\Textarea('description');
        $postDate    = new Element\Hidden('postDate');
        $submit      = new Element\Submit('submit');

        $title->setName('title')
              ->setAttributes([
                    'placeholder' => 'Título',
                    'size'        => 41,
                ])
              ->setLabel('Título')
              ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $description->setName('description')
                    ->setAttributes([
                            'placeholder' => 'Digite o conteúdo',
                            'rows'        => 10,
                            'cols'        => 40,
                        ])
                    ->setLabel('Conteúdo')
                    ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $submit->setAttributes(array(
                                    'value' => 'Enviar',
                                    'id' => 'submitbutton',
                                    'class', 'btn btn-info'
                                    ));

        $this->add($id)
             ->add($title)
             ->add($description)
             ->add($postDate)
             ->add($submit);
    }

    //Retorna um input filter de validação dos campos.
    //@return object O input filter.
    //
    public function addInputFilter()
    {
        if(is_null($this->inputFilter)) {
            $this->inputFilter = new InputFilter();
            $factory           = new InputFactory();

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'id',
                'required' => false,
            )));

            $this->inputFilter->add($factory->createInput(array(
                'name'     => 'title',
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
                'name'     => 'description',
                'required' => false,
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