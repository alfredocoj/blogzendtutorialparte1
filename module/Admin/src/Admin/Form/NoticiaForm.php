<?php

namespace Admin\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class NoticiaForm extends Form
{
    public function __construct()
    {
        parent::__construct('noticias');

        $this->setAttribute('method', 'post');
        $this->setAttribute('class', 'form-horizontal');
        $this->setAttribute('action', '/admin/noticias/create');

        $ntc_id = new Element\Hidden('ntc_id');

        $ntc_data = new Element\Date('ntc_data');
        $ntc_data->setName('ntc_data')
                 ->setLabel('Data*')
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $ntc_mensagem = new Element\Textarea('ntc_mensagem');
        $ntc_mensagem->setName('ntc_mensagem')
                 ->setLabel('Mensagem*')
                 ->setAttributes(array('rows'=>'8','class'=>'span12'))
                 ->setLabelAttributes(array('class'=>'col-sm-2 control-label'));

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Salvar')
               ->setAttribute('class', 'btn btn-info pull-right');

        $this->add($ntc_id)
             ->add($ntc_mensagem)
             ->add($ntc_data)
             ->add($submit);
    }
}
