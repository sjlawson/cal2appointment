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
class clientpipeViewClientpipe extends JView
{
	/**
	 * Clientpipe view display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'Clientpipe Manager' ), 'generic.png' );
		//JToolBarHelper::deleteList();
		JToolBarHelper::editListX();
		//JToolBarHelper::addNewX();

		// Get data from the model
		$items		= & $this->get( 'Data');

		$this->assignRef('items',		$items);

		parent::display($tpl);
	}
}