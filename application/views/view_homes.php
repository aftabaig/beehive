<div id="wrapper">
	<div id="content">
		<div style="float:right; margin-top:30px;"><a href="<?php echo base_url(); ?>index.php/homes/create">
			<img src="<?php echo base_url(); ?>images/btn-addnew.png" width="105" height="32" alt="Add New" /></a>
		</div>
		<div style="clear:both"></div>
		<table id="hor-zebra" width="100%">
			<thead>
				<tr>
					<th scope="col" style="border-right:none;">Id</th>
					<th scope="col" style="border-right:none;">Home Name</th>
					<th scope="col" style="border-right:none;">Edit</th>
					<th scope="col" style="border-right:none;">Delete</th>
				</tr>
			</thead>
			<tbody>
				<?php $i=0; ?>
				<?php foreach ($homes as $home) { ?>
				<?php if ($i%2 == 0) { ?>
				<tr class='even'>
				<?php } else { ?>
				<tr class='odd'>
				<?php } ?>
					<td><?php echo $home->id; ?></td>
					<td><?php echo $home->home_name; ?></td>
					<td><?php echo anchor('homes/edit?home_id='.$home->id,'Edit'); ?></td>
					<td><?php echo anchor('homes/delete?home_id='.$home->id,'Delete'); ?></td>
				</tr>
				<?php $i++; ?>
				<?php } ?>
				<tr style="height:19px;">
					<td colspan="2" style="border-right:none;border-left:none; padding:0;">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</div>
