<?php
/**
 * Clientpipe Model for Clientpipe World Component
 * 
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Clientpipe Model
 *
 * @package    SteamPower.ClientPipe
 * @subpackage Components
 */
class ClientpipeModelAppointment extends JModel
{
	/**
	 * Clientpipe data array
	 *
	 * @var array
	 */
	var $_data;
	public $isAdmin;

	
/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct()
	{
		parent::__construct();

		$array = JRequest::getVar('cid',  0, '', 'array');
		$this->setId((int)$array[0]);
	}

	/**
	 * Method to set the clientpipe identifier
	 *
	 * @access	public
	 * @param	int Clientpipe identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}
	
	public function getStaff($staff_id = null) {
		$db =& JFactory::getDBO();
		if($staff_id) {
		$query = "SELECT * , CONCAT_WS(' ', `firstname` , `lastname`) AS StaffName FROM `#__cp_staff` WHERE `staff_id` = $staff_id";
		$db->setQuery($query);
		$dbResult = $db->loadObject();
		return $dbResult;
		} else {
			$query = "SELECT * , CONCAT_WS(' ', `firstname` , `lastname`) AS StaffName FROM `#__cp_staff` ORDER BY lastname";
		$db->setQuery($query);
		$dbResult = $db->loadObjectList();
		return $dbResult;
			
		}
	}
	/**
	 * Method to get a clientpipe
	 * @return object with data
	 */
	function &getData()
	{
		if(!isset($user))
		$user =& JFactory::getUser();
		
		$this->isAdmin = (
				in_array(8, $user->groups) || 
				in_array(7, $user->groups) ||
				in_array(6, $user->groups) ||
				in_array(5, $user->groups)
				) ? true : false;
		
		if(JRequest::getVar('task') != 'edit' && JRequest::getVar('task') != 'add') {
				if (empty( $this->_data ))
			{
				if($this->isAdmin)
				$query = ' SELECT * FROM #__cp_appointment ORDER BY `appointment_id` DESC ';
				else 
				$query = ' SELECT a.* FROM `#__cp_appointment` a, `#__cp_staff` s 
				WHERE a.`staff_id` = s.`staff_id` 
				AND s.`email` = "'.$user->email.'" 
				HAVING a.`app_date` >= '.date('Y-m-d').'
				 ORDER BY a.`app_date` ASC ';
				
				$this->_data = $this->_getList( $query );
			}

			return $this->_data;
		} 
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__cp_appointment '.
					'  WHERE appointment_id = '.$this->_id;
			$this->_db->setQuery( $query );
			$this->_data = $this->_db->loadObject();
		}
		if (!$this->_data) {
			$this->_data = new stdClass();
		
		}
		return $this->_data;
	}

	/**
	 * Method to store a record
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function store()
	{	
		$row =& $this->getTable();

		$data = JRequest::get( 'post' );

		// Bind the form fields to the clientpipe table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the clientpipe record is valid
		if (!$row->check()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Store the web link table to the database
		if (!$row->store()) {
			$this->setError( $row->getErrorMsg() );
			return false;
		}

		return true;
	}

	/**
	 * Method to delete record(s)
	 *
	 * @access	public
	 * @return	boolean	True on success
	 */
	function delete()
	{
		$cids = JRequest::getVar( 'cid', array(0), 'post', 'array' );

		$row =& $this->getTable();

		if (count( $cids )) {
			foreach($cids as $cid) {
				if (!$row->delete( $cid )) {
					$this->setError( $row->getErrorMsg() );
					return false;
				}
			}
		}
		return true;
	}
	
}