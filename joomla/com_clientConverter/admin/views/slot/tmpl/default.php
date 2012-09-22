<?php defined('_JEXEC') or die('Restricted access'); ?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
<style type="text/css">
.ncMainMenu th {
	height: 33px;
	vertical-align: middle;
	width: 127px;
	text-align: center;
	background-image: url("/administrator/components/com_nucleocal/BlueBtn-alpha.png");
}
.ncMainMenu th a {
	color: white;
}
</style>
<table class="ncMainMenu">
<tr>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=appointment'); ?>
<a href="<?php echo $applink ?>" >Appointments</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=staff'); ?>
<a href="<?php echo $applink ?>" >Staff</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=slot'); ?>
<a href="<?php echo $applink ?>" >Time Slots</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_nucleocal&view=exception'); ?>
<a href="<?php echo $applink ?>" >Schedule Exceptions</a>
</th>
</tr>
</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">Slot
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>			
			<th>Title</th>
			<th>Start Time</th>
			<th>End Time</th>
			<th>Active</th>
			<th>Weekdays</th>
			<th>Openings</th>
			</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->slot_id );
		$link 		= JRoute::_( 'index.php?option=com_nucleocal&controller=slot&task=edit&cid[]='. $row->slot_id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->slot_id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->slot_title; ?></a>
			</td>
			<td>
				<?php echo $row->time_start; ?>
			</td>
			<td>
				<?php echo $row->time_end; ?>
			</td>
			<td>
				<?php  echo $row->default_slot; ?>
			</td>
			<td>
				<?php echo $row->weekdays_csv; ?>
			</td>
			<td>
				<?php echo $row->openings; ?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_nucleocal" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="slot" />
</form>
