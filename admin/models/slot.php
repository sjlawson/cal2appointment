<?php
/**
 * Nucleocal Model for Nucleocal World Component
 * 
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_4
 * @license		GNU/GPL
 */

// No direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

/**
 * Nucleocal Model
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class NucleocalModelSlot extends JModel
{
	/**
	 * Nucleocal data array
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
	 * Method to set the nucleocal identifier
	 *
	 * @access	public
	 * @param	int Nucleocal identifier
	 * @return	void
	 */
	function setId($id)
	{
		// Set id and wipe data
		$this->_id		= $id;
		$this->_data	= null;
	}

	/**
	 * Method to get a nucleocal
	 * @return object with data
	 */
	function &getData()
	{
		if(JRequest::getVar('task') != 'edit' && JRequest::getVar('task') != 'add') {
				if (empty( $this->_data ))
			{
				$query = ' SELECT * FROM #__nc_slot ORDER BY `slot_id` DESC ';
				$this->_data = $this->_getList( $query );
			}

			return $this->_data;
		} 
		// Load the data
		if (empty( $this->_data )) {
			$query = ' SELECT * FROM #__nc_slot '.
					'  WHERE slot_id = '.$this->_id;
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
		$data['weekdays_csv'] = implode(',',$data['weekdays_csv']);
		// Bind the form fields to the nucleocal table
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		// Make sure the nucleocal record is valid
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