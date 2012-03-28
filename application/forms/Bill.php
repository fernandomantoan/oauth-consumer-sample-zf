<?php

class Application_Form_Bill extends Zend_Form
{
	public function init()
	{
		$this->setMethod(Zend_Form::METHOD_POST);
		
		$id = new Zend_Form_Element_Hidden('id');
		
		$id->setDecorators(array('ViewHelper'));
		
		$title = new Zend_Form_Element_Text('title');
		$title->setLabel('Title:')
			  ->setRequired(true)
			  ->addValidator(new Zend_Validate_StringLength(array('max' => 255)))
			  ->addFilter('stringTrim')
			  ->addFilter('stripTags');
		
		$price = new Zend_Form_Element_Text('price');
		$price->setLabel('Price:')
			  ->setRequired(true)
			  ->addValidator(new Zend_Validate_Float())
			  ->addFilter('stringTrim')
			  ->addFilter('stripTags');
		
		$type = new Zend_Form_Element_Radio('type');
		$type->setLabel('Type:')
			 ->addMultiOption('CREDIT', 'Crédito')
			 ->addMultiOption('DEBIT', 'Débito')
			 ->setRequired(true);
		
		$submit = new Zend_Form_Element_Submit('submit');
		$submit->setLabel('Save')
			   ->setAttrib('class', 'button white');
		
		$this->addElements(array($id, $title, $price, $type, $submit));
	}
}