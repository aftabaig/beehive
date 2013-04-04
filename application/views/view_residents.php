<style>
#hor-zebra tr.even:hover {
	background-color:#ccc;
}
#hor-zebra tr.odd:hover {
	background-color:#ccc;
}
</style>
<div id="wrapper">
	<div id="content">
		<div style="float:right; margin-top:30px;"><a href="<?php echo base_url(); ?>index.php/residents/create">
			<img src="<?php echo base_url(); ?>images/btn-addnew.png" width="105" height="32" alt="Add New" /></a>
		</div>
		<div style="clear:both"></div>
		<table id="hor-zebra" width="100%">
			<thead>
				<tr>
					<th scope="col" style="border-right:none;">Id</th>
					<th scope="col" style="border-right:none;">Resident Name</th>
					<th scope="col" style="border-right:none;">Edit</th>
					<th scope="col" style="border-right:none;">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; ?>
				<?php foreach ($residents as $resident) { ?>
				<?php if ($i%2 == 0) { ?>
				<tr class='even'>
				<?php } else { ?>
				<tr class='odd'>
				<?php } ?>
					<td><?php echo $resident->id; ?></td>
					<td><?php echo $resident->first_name.' '.$resident->last_name.' ('.$resident->nick_name.')'; ?></td>
					<td><?php echo anchor('residents/edit?resident_id='.$resident->id,'Edit'); ?></td>
					<td><?php echo anchor('residents/delete?resident_id='.$resident->id,'Delete'); ?></td>
				</tr>
				<?php $i++; ?>
				<?php } ?>
				<tr style="height:19px;">
					<td colspan="2" style="border-right:none;border-left:none; padding:0;">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>
