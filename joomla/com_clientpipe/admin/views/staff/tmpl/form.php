<?php defined('_JEXEC') or die('Restricted access'); 
if(!isset($dbo))
$dbo =& JFactory::getDBO();

$sql = "SELECT * FROM `#__cp_slot` ORDER BY `default_slot`, `time_start` ";
$dbo->setQuery($sql);
$objSlotList = $dbo->loadObjectList();

$sql = "SELECT * FROM `#__cp_slot_alloc` WHERE `staff_id` = ".$this->staff->staff_id;
$dbo->setQuery($sql);
$objAllocList = $dbo->loadObjectList();
$slotIdList = array();
foreach ($objAllocList as $alloc) {
	$slotIdList[] = $alloc->slot_id;
}


//	<input class="text_area" type="text" name="slot_title" id="slot_title" size="32" maxlength="80" value="<?php echo $this->slot->slot_title;

?>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
		<td width="100" align="right" class="key">
				<label for="firstname">
					First Name 
				</label>
			</td>
			<td> 
			 <input class="text_area" type="text" name="firstname" id="firstname" size="32" maxlength="80" value="<?php echo $this->staff->firstname; ?>" />			
			</td>
		</tr>
		
		<tr>
		<td width="100" align="right" class="key">
				<label for="lastname">
					Last Name 
				</label>
			</td>
			<td> 
			 <input class="text_area" type="text" name="lastname" id="lastname" size="32" maxlength="80" value="<?php echo $this->staff->lastname; ?>" />			
			</td>
		</tr>
		<tr>
		<td width="100" align="right" class="key">
				<label for="email">
					Email 
				</label>
			</td>
			<td> 
			 <input class="text_area" type="text" name="email" id="email" size="32" maxlength="80" value="<?php echo $this->staff->email; ?>" />			
			</td>
		</tr>
		<tr>
		<td width="100" align="right" class="key">
				<label for="contact_info">
					Contact information 
				</label>
			</td>
			<td> 
			<textarea rows="4" cols="40" name="contact_info" id="contact_info" >
			 <?php echo $this->staff->contact_info; ?> 			
			 </textarea>
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="slot_id">
					Assign to Slots <br />
					<small>(optional)<br />
					Click & Hold Ctl or CMD to select multiple</small>
				</label>
			</td>
			<td>
			<select multiple name="slot_id[]" id="slot_id" >
			<option value="none" <?php if(count($slotIdList) < 1) echo "selected='selected' "; ?> >none</option>
			<?php 
			foreach($objSlotList as $slot ) {
				echo "<option value='".$slot->slot_id."' ";
				if(in_array($slot->slot_id, $slotIdList))
					echo "selected='selected' ";
				echo ">".$slot->slot_title."</option>";
			}
			
			?>
			
			</select>
			</td>	
			</tr>
			
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_clientpipe" />
<input type="hidden" name="staff_id" value="<?php echo $this->staff->staff_id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="staff" />
</form>
