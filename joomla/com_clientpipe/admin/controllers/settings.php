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
class ClientpipeControllersettings extends ClientpipeController
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
		JRequest::setVar( 'view', 'settings' );
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
		$model = $this->getModel('settings');

		if ($model->store($post)) {
			$msg = JText::_( 'Configuration Saved' );
		} else {
			$msg = JText::_( 'Error Saving Configuration' );
		}

		$link = 'index.php?option=com_clientpipe&view=settings';
		$this->setRedirect($link, $msg);
	}

	/**
	 * remove record(s)
	 * @return void
	 */
	function remove()
	{
		$model = $this->getModel('settings');
		if(!$model->delete()) {
			$msg = JText::_( 'Error: One or More Settings Could not be Deleted' );
		} else {
			$msg = JText::_( 'Settings(s) Deleted' );
		}

		$this->setRedirect( 'index.php?option=com_clientpipe&view=settings', $msg );
	}

	/**
	 * cancel editing a record
	 * @return void
	 */
	function cancel()
	{
		$msg = JText::_( 'Operation Cancelled' );
		$this->setRedirect( 'index.php?option=com_clientpipe&view=settings', $msg );
	}
}