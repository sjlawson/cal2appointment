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
class TableClientpipe extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	/**
	 * @var string
	 */
	var $greeting = null;

	/**
	 * @var string
	 */
	var $calendar_title = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableClientpipe(& $db) {
		parent::__construct('#__cp_clientpipe', 'id', $db);
	}
}