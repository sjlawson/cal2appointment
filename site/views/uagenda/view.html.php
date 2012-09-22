<?php


jimport( 'joomla.application.component.view');

/**
 * HTML View class for the NucleocalWorld Component
 *
 * @package		Joomla.Tutorials
 * @subpackage	Components
 */


class NucleocalViewUagenda extends JView
{
	var $greeting;
	var $title;
	var $resultMsg = null;
	var $ncOptions;
	var $appointments;
	
	function display($tpl = null)
	{

		
		$this->greeting = $this->get( 'Greeting' );
		$this->assignRef( 'greeting',	$this->greeting );
		$this->ncTitle = $this->get( 'Title' );
		
		$this->ncOptions = $this->get( 'Options' );
		
		$this->appointments = $this->get( 'Appointments' );
		
		parent::display($tpl);
	}
	
}

?>
