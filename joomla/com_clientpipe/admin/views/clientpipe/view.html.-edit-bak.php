<?php
/**
 * Clientpipe View for Clientpipe Component
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
class clientpipeViewclientpipe extends JView
{
	/**
	 * display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the clientpipe
		$clientpipe		=& $this->get('Data');
		$isNew		= ($clientpipe->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Clientpipe' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('clientpipe',		$clientpipe);

		parent::display($tpl);
	}
}