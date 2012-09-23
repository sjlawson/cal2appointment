<?php defined('_JEXEC') or die('Restricted access');
if(!isset($dbo))
$dbo =& JFactory::getDBO();

?>
<form action="index.php" method="post" name="adminForm">
<div id="editcell">
<style type="text/css">
.ncMainMenu th {
	height: 33px;
	vertical-align: middle;
	width: 127px;
	text-align: center;
	background-image: url("/administrator/components/com_clientpipe/BlueBtn-alpha.png");
}
.ncMainMenu th a {
	color: white;
}
</style>
<table class="ncMainMenu">
<tr>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_clientpipe&view=appointment'); ?>
<a href="<?php echo $applink ?>" >Appointments</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_clientpipe&view=staff'); ?>
<a href="<?php echo $applink ?>" >Staff</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_clientpipe&view=slot'); ?>
<a href="<?php echo $applink ?>" >Time Slots</a>
</th>
<th>
<?php $applink = JRoute::_( 'index.php?option=com_clientpipe&view=exception'); ?>
<a href="<?php echo $applink ?>" >Schedule Exceptions</a>
</th>
</tr>
</table>
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5">Exception
				<?php echo JText::_( 'ID' ); ?>
			</th>
			<th width="20">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->items ); ?>);" />
			</th>			
			<th>Date of Exception</th>
			<th>Slot</th>
			<th>Schedule Changes</th>
			<th>All-Off</th>
			<th>Openings</th>
			</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->items ); $i < $n; $i++)	{
		$row = &$this->items[$i];
		$checked 	= JHTML::_('grid.id',   $i, $row->exception_id );
		$link 		= JRoute::_( 'index.php?option=com_clientpipe&controller=exception&task=edit&cid[]='. $row->exception_id );
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td>
				<?php echo $row->exception_id; ?>
			</td>
			<td>
				<?php echo $checked; ?>
			</td>
			<td>
				<a href="<?php echo $link; ?>"><?php echo $row->exception_date; ?></a>
			</td>
			<td>
				<?php
				if($row->slot_id) {
				$dbo->setQuery('SELECT * FROM `#__cp_slot` WHERE `slot_id` = '.$row->slot_id ); 
				$objSlot = $dbo->loadObject();
				echo $objSlot->slot_title;
				}
				?>
			</td>
			<td><?php 
			if($row->on_staff_id_csv || $row->off_staff_id_csv) echo "Edit to see changes to staff";
			?>
			</td>
			<td>
				<?php
				echo $row->all_off;
				?>
			</td>
			<td>
				<?php  echo $row->openings; ?>
			</td>
			
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>
	</table>
</div>

<input type="hidden" name="option" value="com_clientpipe" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="controller" value="exception" />
</form>
