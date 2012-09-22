<?php
/**
 * Nucleocal Controller for Nucleocal Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Nucleocal Nucleocal Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class NucleocalControllerstaff extends NucleocalController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();

		// Register Extra tasks
		$this->registerTask( 'add'  , 	'edit' );
	}

	/**
	 * display the edit form
	 * @return void
	 */
	function edit()
	{
		JRequest::setVar( 'view', 'staff' );
		JRequest::setVar( 'layout', 'form'  );
		JRequest::setVar('hidemainmenu', 1);

		parent::display();
	}

	/**
	 * save a record (and redirect to main page)
	 * @return void
	 */
	function save()
	{
		$model = $this->getModel('staff');

		if ($model->store($post)) {
			$msg = JText::_( 'Staff Saved' );
		} else {
			$msg = JText::_( 'Error Saving Staff' );
		}

		$link = 'index.php?option=com_nucleocal&view=staff';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('staff');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Staff Could not be Deleted' );
		} else {
			$msg = JText::_( 'Staff Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_nucleocal&view=staff', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_nucleocal&view=staff', $msg );
	}
}