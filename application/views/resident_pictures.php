<script>
function change_pic_source()
{
  var dropdown = document.getElementsByName('relative_id')[0];
  var url = '<?php echo base_url(); ?>index.php/pictures/resident?relative_id='+dropdown.value;
  window.location=url;
}
</script>
<div id="wrapper">
<div id="content">
  <div class="btn"> <a href='<?php echo base_url(); ?>index.php/pictures/upload'>Upload Pictures</a> </div>
  <div style="float:right; margin-top:30px; margin-right:7px;">
    <label style=" position:relative; color:#392115;">Show Pictures From</label>
    <div style="position:relative; display:inline; width:209px; left:5px;">
      <?php echo form_dropdown('relative_id',$relatives,$selected,'onChange="change_pic_source();"'); ?>
    </div>
  </div>
  <div style="clear:both"></div>
  <?php foreach ($picture_groups as $group) { ?>
  	<?php if ($group->to_forth === '1') { ?>
  	  <div style="float:left;">
  	<?php } else { ?>
  	  <div style="float:right;">
  	<?php } ?>
  	    <div class="msg">
  	      <p>
  	      <?php foreach ($group->pictures as $picture) { ?>
  	      <a href='<?php echo base_url(); ?>/uploads/<?php echo $picture->file_name?>'>
  	      	<img src='<?php echo base_url(); ?>/uploads/<?php echo $picture->file_name?>'>
  	      </a>
  	      <?php } ?>
  	      </p>
  	    </div>
  	    <p><strong><?php if ($group->to_forth === '1') { echo $group->resident_first_name.' '.$group->resident_last_name; } else { echo $group->relative_first_name.' '.$group->relative_last_name; } ?></strong> at <?php echo $group->group_date; ?></p>
  	  </div>
  <?php } ?>