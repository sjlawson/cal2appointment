<?php
/**
 * Nucleocal World table class
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Nucleocal Table class
 *
 * @package    Joomla.Tutorials
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
		parent::__construct('#__nc_event', 'event_id', $db);
	}
}