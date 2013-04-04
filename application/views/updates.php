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
      <div style="position:relative; display:inline; width:209px; left:5px;">
        <div class="btn">
          <?php echo anchor('push/compose_updates','Send Updates'); ?>
        </div>
      </div>
    </div>
    <div style="clear:both"></div>
    <table id="hor-zebra" width="100%">
      <thead>
        <tr>
          <th width="34%" scope="col" >Date</th>
          <th scope="col" style="border-right:none;">Notification </th>
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
			  <td><?php echo $message->timestamp; ?></td>
		  	  <td><?php echo $message->message; ?></td>
			</tr>
		  <?php $i++; ?>
		  <?php } ?>
        	<tr style="height:19px;" label='last_row'>
          	  <td colspan="6" style="border-right:none;border-left:none; padding:0;">&nbsp;</td>
        	</tr>
      </tbody>
    </table>
  </div>
