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
class TableException extends JTable
{
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $exception_id = null;

	var $exception_date = null;
	
	var $slot_id = null;
	
	var $on_staff_id_csv = null;
	
	var $off_staff_id_csv = null;
	
	var $all_off = null;
	
	var $openints = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 */
	function TableException(& $db) {
		parent::__construct('#__nc_exception', 'exception_id', $db);
	}
}