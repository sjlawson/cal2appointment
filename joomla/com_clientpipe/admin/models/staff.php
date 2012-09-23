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
class ClientpipeModelStaff extends JModel
{
	/**
	 * Clientpipe data array
	 *
	 * @var array
	 */
	var $_data;


	
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
	

	/**
	 * Method to get a clientpipe
	 * @return object with data
	 */
	function &getData()
	{
		if(JRequest::getVar('task') != 'edit' && JRequest::getVar('task') != 'add') {
				if (empty( $this->_data ))
			{
				$query = ' SELECT * FROM #__cp_staff ORDER BY `staff_id` DESC ';
				$this->_data = $this->_getList( $query );
			}

			return $this->_data;
		} 
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__cp_staff '.
					'  WHERE staff_id = '.$this->_id;
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
		if(!isset($dbo))
		 $dbo =& JFactory::getDBO();
			
		 $data = JRequest::get( 'post' );
		 
		$sql = "SELECT * FROM `#__cp_slot_alloc` WHERE `staff_id` = ".$data['staff_id'];
		$dbo->setQuery($sql);
		$objAllocList = $dbo->loadObjectList();
		$slotIdList = array();
		foreach ($objAllocList as $alloc) {
			$oldslots[] = $alloc->slot_id;
		}
		 
		
		if((is_array($data['slot_id']) && count($data['slot_id'])) || count($oldslots) ) {
			
			if(in_array('none',$data['slot_id'])) {
				$dbo->setQuery("DELETE FROM `#__cp_slot_alloc` WHERE `staff_id` = ".$data['staff_id']);
				$dbo->query();
			} else {
				foreach($data['slot_id'] as $selectedSlot) {
					if(!in_array($selectedSlot, $oldslots)) {
						//add new slot alloc record
						$sql = "INSERT INTO `#__cp_slot_alloc` ( `staff_id`, `slot_id` ) VALUES 
						( ".$data['staff_id'].", ".$selectedSlot .") ";
						$dbo->setQuery($sql);
						$dbo->query();
					}
					
				}
				foreach($oldslots as $oldslot ) {
					if(!in_array($oldslot, $data['slot_id'])) {
						//remove slot alloc record
						$sql = "DELETE FROM `#__cp_slot_alloc` WHERE `slot_id` = $oldslot 
						AND `staff_id` = ".$data['staff_id'];
						$dbo->setQuery($sql);
						$dbo->query();
					}
				}
			}
		}
		
		//unset($data['slot_id']);
		
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