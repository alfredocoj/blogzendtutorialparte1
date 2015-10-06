<?php
namespace Core\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\Form;
use Zend\Form\View\Helper;
use Zend\Form\ElementInterface;

class ElementToSubmit extends AbstractHelper
{
  /*
   * Returns an HTML table row using a form element
   * <tr><td></td>
   * @param string $elementName = name of the element to render
   * @return string $html
   */
  public function render(ElementInterface $element)
  {

    $formElement = new Helper\FormElement();
    $formErrors  = new Helper\FormElementErrors();
    $view      = $this->getView();
    $formElement->setView($view);
    $formErrors->setView($view);

    $html = "
        <div class='form-group'>
          <div class='col-sm-offset-2 col-sm-10'>
            ".$formElement($element)."
          </div>
        </div>";

    return $html;
  }

  public function __invoke(ElementInterface $element)
  {
    return $this->render($element);
  }
}
