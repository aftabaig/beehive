<script>
function change_msg_source()
{
  var dropdown = document.getElementsByName('relative_id')[0];
  var url = '<?php echo base_url(); ?>index.php/messages/resident?relative_id='+dropdown.value;
  window.location=url;
}
</script>
<div id="wrapper">
<div id="content">
  <div class="btn"> <a href='<?php echo base_url(); ?>index.php/messages/compose'>Send Message</a> </div>
  <div style="float:right; margin-top:30px; margin-right:7px;">
    <label style=" position:relative; color:#392115;">Show Messages From</label>
    <div style="position:relative; display:inline; width:209px; left:5px;">
      <?php echo form_dropdown('relative_id',$relatives,$selected,'onChange="change_msg_source();"'); ?>
    </div>
  </div>
  <div style="clear:both"></div>
  <?php foreach ($messages as $message) { ?>
  	<?php if ($message->to_forth === '1') { ?>
  	  <div style="float:left;">
  	<?php } else { ?>
  	  <div style="float:right;">
  	<?php } ?>
  	    <div class="msg">
  	      <p><?php echo $message->message; ?></p>
  	    </div>
  	    <p><strong><?php if ($message->to_forth === '1') { echo $message->resident_first_name.' '.$message->resident_last_name; } else { echo $message->relative_first_name.' '.$message->relative_last_name; } ?></strong> at <?php echo $message->message_date; ?></p>
  	  </div>
  <?php } ?>