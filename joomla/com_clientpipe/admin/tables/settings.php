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
class TableSettings extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $option_id = null;
	
	var $field_name = null;
	
	var $field_description = null;
	
	var $field_tooltip = null;
	
	var $field_value = null;

	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSettings(& $db) {
		parent::__construct('#__cp_options', 'option_id', $db);
	}
}