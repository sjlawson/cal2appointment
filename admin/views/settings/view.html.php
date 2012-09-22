<?php
/**
 * Nucleocal View for Nucleocal World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Nucleocal View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class nucleocalViewSettings extends JView
{
	/**
	 * Nucleocal view display method
	 * @return void
	 **/
	
	function display($tpl = null)
	{
		//echo JRequest::getVar('task');	
		if(JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add')  {
			$staff		=& $this->get('Data');
		$isNew		= ($staff->staff_id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Configuration' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('settings',		$settings);
		} else {
		
		JToolBarHelper::title(   JText::_( 'Configuration Manager' ), 'generic.png' );
		//JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items', $items);
		}
			
		

		parent::display($tpl);
		
		
	}
}