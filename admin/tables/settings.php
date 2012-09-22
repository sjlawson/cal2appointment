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
		parent::__construct('#__nc_options', 'option_id', $db);
	}
}