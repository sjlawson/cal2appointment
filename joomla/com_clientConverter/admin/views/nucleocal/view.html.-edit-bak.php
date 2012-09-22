<?php
/**
 * Nucleocal View for Nucleocal Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );

/**
 * Nucleocal View
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class nucleocalViewnucleocal extends JView
{
	/**
	 * display method
	 * @return void
	 **/
	function display($tpl = null)
	{
		//get the nucleocal
		$nucleocal		=& $this->get('Data');
		$isNew		= ($nucleocal->id < 1);

		$text = $isNew ? JText::_( 'New' ) : JText::_( 'Edit' );
		JToolBarHelper::title(   JText::_( 'Nucleocal' ).': <small><small>[ ' . $text.' ]</small></small>' );
		JToolBarHelper::save();
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
			// for existing items the button is renamed `close`
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}

		$this->assignRef('nucleocal',		$nucleocal);

		parent::display($tpl);
	}
}