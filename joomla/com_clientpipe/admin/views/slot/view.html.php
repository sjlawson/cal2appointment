<?php
/**
 * Clientpipe View for Clientpipe World Component
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Clientpipe View
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class clientpipeViewslot extends JView
{
	/**
	 * Clientpipe view display method
	 * @return void
	 **/
	
	function display($tpl = null)
	{
		//echo JRequest::getVar('task');	
		if(JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add')  {
			$slot		=& $this->get('Data');
		$isNew		= ($slot->slot_id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Slot' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('slot',		$slot);
		} else {
		
		JToolBarHelper::title(   JText::_( 'Slot Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items', $items);
		}
			
		

		parent::display($tpl);
		
		
	}
}