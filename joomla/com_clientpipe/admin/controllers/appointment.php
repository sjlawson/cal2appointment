<?php
/**
 * Clientpipe Controller for Clientpipe World Component
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

/**
 * Clientpipe Clientpipe Controller
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class ClientpipeControllerappointment extends ClientpipeController
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
		JRequest::setVar( 'view', 'appointment' );
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
		$model = $this->getModel('appointment');

		if ($model->store($post)) {
			$msg = JText::_( 'Appointment Saved' );
		} else {
			$msg = JText::_( 'Error Saving Appointment' );
		}

		$link = 'index.php?option=com_clientpipe&view=appointment';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('appointment');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Appointments Could not be Deleted' );
		} else {
			$msg = JText::_( 'Appointment(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_clientpipe&view=appointment', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_clientpipe&view=appointment', $msg );
	}
}