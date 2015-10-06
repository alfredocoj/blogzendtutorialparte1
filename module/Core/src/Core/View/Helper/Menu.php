<?php

namespace Core\View\Helper;
use Zend\View\Helper\AbstractHelper;

class Menu extends AbstractHelper
{
    public function render($itens){
        var_dump($itens);
    }

    public function __invoke($itens)
    {
        $this->render($itens);
    }
}
