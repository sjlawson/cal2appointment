<?php
/**
 * Clientpipe Controller for Clientpipe Component
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
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
class ClientpipeControllerslot extends ClientpipeController
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
		JRequest::setVar( 'view', 'slot' );
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
		$model = $this->getModel('slot');

		if ($model->store($post)) {
			$msg = JText::_( 'Slot Saved' );
		} else {
			$msg = JText::_( 'Error Saving Slot' );
		}

		$link = 'index.php?option=com_clientpipe&view=slot';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('slot');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Slots Could not be Deleted' );
		} else {
			$msg = JText::_( 'Slot(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_clientpipe&view=slot', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_clientpipe&view=slot', $msg );
	}
}