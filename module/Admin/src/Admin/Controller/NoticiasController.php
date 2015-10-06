<?php
namespace Admin\Controller;

use Core\Controller\CRUDController;

use Admin\Form\NoticiaForm;
use Admin\Entity\Noticia;

class NoticiasController extends CRUDController
{
    public function __construct()
    {
        $entity     = new Noticia;
        $model      = Constantes::MODEL_NOTICIA;
        $form       = new NoticiaForm;
        $actionBase = '/admin/noticias';
        $label      = 'Notícias';

        parent::__construct($entity, $model, $form, $actionBase, $label);
    }
}
