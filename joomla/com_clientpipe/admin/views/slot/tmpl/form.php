<?php defined('_JEXEC') or die('Restricted access'); ?>

<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col100">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'Details' ); ?></legend>

		<table class="admintable">
		<tr>
			<td width="100" align="right" class="key">
				<label for="slot_title">
					Slot Title
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="slot_title" id="slot_title" size="32" maxlength="80" value="<?php echo $this->slot->slot_title;?>" />
			</td>	
			</tr>
			<tr>
				
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="time_start">
					Start Time <br />
					<small>24hr format: e.g. 14:00</small>
				</label>
			</td>
			<td> 
				<input class="text_area" type="text" name="time_start" id="time_start" size="32" maxlength="80" value="<?php echo $this->slot->time_start;?>" />
			
			</td>	
			</tr>
				<tr>
			<td width="100" align="right" class="key">
				<label for="time_end">
					End Time<br />
					<small>24hr format: e.g. 14:00</small>
				</label>
			</td>
			<td> 
				<input class="text_area" type="text" name="time_end" id="time_end" size="32" maxlength="80" value="<?php echo $this->slot->time_end;?>" />
			
			</td>	
			</tr>
			<tr>
			<td width="100" align="right" class="key">
				<label for="default_slot">
					 Active/Default Slot<br />
					<small>(Leave unchecked if only for schedule exceptions)</small>
				</label>
			</td>
			<td>
				<input name="default_slot" id="default_slot" type="checkbox" value='1' <?php if($this->slot->default_slot) echo "checked='true' " ?> />
			</td>
			</tr>
		<tr>
			<td width="100" align="right" class="key">
				<label for="weekdays_csv">
					Weekdays
				</label>
			</td>
			<td>
			
				<select multiple name='weekdays_csv[]' id='weekdays_csv' size='7' >
				<?php $weekdays = explode(',',$this->slot->weekdays_csv); ?>
				<option <?php if(in_array('Mon',$weekdays)) echo "selected='selected' "; ?> value='Mon'>Mon</option>
				<option <?php if(in_array('Tue',$weekdays)) echo "selected='selected' "; ?>value='Tue'>Tue</option>
				<option <?php if(in_array('Wed',$weekdays)) echo "selected='selected' "; ?>value='Wed'>Wed</option>
				<option <?php if(in_array('Thu',$weekdays)) echo "selected='selected' "; ?>value='Thu'>Thu</option>
				<option <?php if(in_array('Fri',$weekdays)) echo "selected='selected' "; ?>value='Fri'>Fri</option>
				<option <?php if(in_array('Sat',$weekdays)) echo "selected='selected' "; ?>value='Sat'>Sat</option>
				<option <?php if(in_array('Sun',$weekdays)) echo "selected='selected' "; ?>value='Sun'>Sun</option>
				
		</select>
		</td></tr>
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="openings">
					Openings in this slot
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="openings" id="openings" size="32" maxlength="80" value="<?php echo $this->slot->openings;?>" />
			
			</td>
		</tr>
	</table>
	</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="option" value="com_clientpipe" />
<input type="hidden" name="slot_id" value="<?php echo $this->slot->slot_id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="controller" value="slot" />
</form>
