<?php
/**
 * Nucleocal Model for Nucleocal World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://dev.joomla.org/component/option,com_jd-wiki/Itemid,31/id,tutorials:components/
 * @license		GNU/GPL
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.model' );

/**
 * Nucleocal Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class NucleocalModelNucleocal extends JModel
{
	/**
	 * Gets the greeting
	 * @return string The greeting to be displayed to the user
	 */
	function getGreeting()
	{
		$db =& JFactory::getDBO();

		$query = 'SELECT greeting FROM #__nc_nucleocal';
		$db->setQuery( $query );
		$greeting = $db->loadResult();

		return $greeting;
	}
	function getTitle()
	{
	$db =& JFactory::getDBO();

		$query = 'SELECT calendar_title FROM #__nc_nucleocal';
		$db->setQuery( $query );
		$ncTitle = $db->loadResult();

		return $ncTitle;	
	}
	
}
