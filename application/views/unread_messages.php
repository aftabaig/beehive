<script>
function change_msg_source()
{
  var dropdown = document.getElementsByName('resident_id')[0];
  var url = '<?php echo base_url(); ?>index.php/messages/unread?resident_id='+dropdown.value;
  window.location=url;
}
</script>
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
    <div style="float:right; margin-top:30px; margin-bottom:10px; margin-right:7px;">
      <label style=" position:relative; color:#392115;">Show</label>
      <div style="position:relative; display:inline; width:209px; left:5px;">
        <?php echo form_dropdown('resident_id',$residents,$selected,'onChange="change_msg_source();"'); ?>
      </div>
    </div>
    <div style="clear:both"></div>
    <table id="hor-zebra" width="100%">
      <thead>
        <tr>
          <th width="34%" scope="col" >To</th>
          <th width="34%" scope="col">From</th>
          <th scope="col" style="border-right:none;">Date </th>
        </tr>
      </thead>
      <tbody>
        <?php $i=0; ?>
	    <?php foreach ($messages as $message) { ?>
		  <?php if ($i%2 == 0) { ?>
			<tr class='even' label='unread_msgs'>
		  <?php } else { ?>
			<tr class='odd' label='unread_msgs'>
		  <?php } ?>
		  	  <input type='hidden' name='resident_id' value='<?php echo $message->resident_id; ?>'/>
		  	  <input type='hidden' name='relative_id' value='<?php echo $message->relative_id; ?>'/>
		  	  <td><?php echo $message->resident_first_name.' '.$message->resident_last_name; ?></td>
			  <td><?php echo $message->relative_first_name.' '.$message->relative_last_name; ?></td>
			  <td><?php echo $message->message_date; ?></td>
			</tr>
		  <?php $i++; ?>
		  <?php } ?>
        	<tr style="height:19px;" label='last_row'>
          	  <td colspan="6" style="border-right:none;border-left:none; padding:0;">&nbsp;</td>
        	</tr>
      </tbody>
    </table>
  </div>
