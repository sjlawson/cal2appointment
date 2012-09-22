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
class TableSlot_alloc extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $slot_alloc_id = null;
	
	var $slot_id = null;
	
	var $staff_id = null;
	


	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableSlot_alloc(& $db) {
		parent::__construct('#__nc_slot_alloc', 'slot_alloc_id', $db);
	}
}