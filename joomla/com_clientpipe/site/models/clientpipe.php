<?php
/**
 * Clientpipe Model for Clientpipe World Component
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://sjlawson.sdf.org/steampower
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Clientpipe Model
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class ClientpipeModelClientpipe extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getGreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT greeting FROM #__cp_clientpipe';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	function getTitle()
	{
	$db =& JFactory::getDBO();

		$query = 'SELECT calendar_title FROM #__cp_clientpipe';
		$db->setQuery( $query );
		$ncTitle = $db->loadResult();

		return $ncTitle;	
	}
	
}
