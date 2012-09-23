<?php
/**
 * Clientpipe World table class
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Clientpipe Table class
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class TableEvent extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $event_id = null;

	/**
	 * @var string
	 */
	var $description = null;

	/**
	 * @var string
	 */
	var $title = null;
	
	var $event_start = null;
	var $event_end = null;
	var $allday = null;
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableEvent(& $db) {
		parent::__construct('#__cp_event', 'event_id', $db);
	}
}