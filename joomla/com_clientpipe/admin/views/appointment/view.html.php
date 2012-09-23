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
class clientpipeViewappointment extends JView
{
	/**
	 * Clientpipe view display method
	 * @return void
	 **/
	public $objSlotList;
	public $objStaffList;
	
	function display($tpl = null)
	{
		if(!isset($dbo))
			$dbo =& JFactory::getDBO();
		//echo JRequest::getVar('task');	
		if(JRequest::getVar('task') == 'edit' || JRequest::getVar('task') == 'add')  {
			$appointment		=& $this->get('Data');
		$isNew		= ($appointment->appointment_id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Appointment' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('appointment',		$appointment);
		} else {
		
		JToolBarHelper::title(   JText::_( 'Appointment Manager' ), 'generic.png' );
		JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		JToolBarHelper::addNewX();

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items', $items);
		}
			
		
		$sql = "SELECT * FROM `#__cp_slot` ORDER BY `default_slot`, `time_start`";
		$dbo->setQuery($sql);
		$this->objSlotList = $dbo->loadObjectList();
		
		$sql = "SELECT * FROM `#__cp_staff` ORDER BY `lastname`";
		$dbo->setQuery($sql);
		$this->objStaffList = $dbo->loadObjectList();

		parent::display($tpl);
		
		
	}
}