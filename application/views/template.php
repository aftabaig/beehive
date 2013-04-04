<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  		<title>Bee Homes | <?php echo $title ?></title>
		<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/jquery.multifile.css" media="screen" />
		<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.js"></script>
		<script src="<?php echo base_url(); ?>js/jquery.multifile.min.js" type="text/javascript" language="javascript"></script> 
		<script>
			$(document).ready(function() {
				//$("#multifile").multifile();
				$('#hor-zebra tr').click(function() {
    				var label = $(this).attr('label');
    				if (label == "last_row")
    				{
    					return;
    				}
    				if (label == "unread_msgs")
    				{
    					var hiddens = $(this).find("input");
    					var resident_id = hiddens[0].getAttribute('value');
    					var relative_id = hiddens[1].getAttribute('value');
    					var url = '<?php echo base_url(); ?>index.php/messages/resident?resident_id='+resident_id+'&relative_id='+relative_id;
    					if (url) {
    						window.location = url;
    					}
    				}
    				else if (label == "unread_pics")
    				{
    					var hiddens = $(this).find("input");
    					var resident_id = hiddens[0].getAttribute('value');
    					var relative_id = hiddens[1].getAttribute('value');
    					var url = '<?php echo base_url(); ?>index.php/pictures/resident?resident_id='+resident_id+'&relative_id='+relative_id;
    					if (url) {
    						window.location = url;
    					}
    				}
    				else 
    				{
    					var tds = $(this).find("td");
        				var resident_id = tds[0].innerText;
        				var url = '<?php echo base_url(); ?>index.php/residents/rhome?resident_id='+resident_id;
        				if (url) {
        					window.location = url;
        				}
        			}
    			});
			});
		</script>
		<script>
			$(document).ready(function() {
				$("#datepicker").datepicker();
			});
		</script>
		<script>selectBox();</script>
		<script type="text/javascript">
			jQuery(function(){ 
				jQuery('.jbar').jbar();
			});
		</script>
		<!--[if IE 6]>
		<script src="png/png-fix.js" type="text/javascript"></script>
		<script src="png/png.js" type="text/javascript"></script>
		<![endif]-->
	</head>

	<body>

		<!--header-->
		<div class="outer-top-menu">
			<div class="top-menu">
				<ul>
					<li>Welcome <?php echo $this->session->userdata('username') ?>! </li>
					<li><?php echo anchor('users/logout','Logout'); ?></li>
				</ul>
			</div>
		</div>
		
		<div class="header">
			<div class="inner-header">
				<div class="logo"><a href="#"><img src="<?php echo base_url(); ?>images/logo.png" alt="Bee Hive" width="169" height="69" /></a></div>
				<div class="menu">
					<ul>
						<?php $method = $this->router->fetch_method(); ?>
						<?php if ($method === 'index') { ?>
							<li class="menuselect">Home
						<?php } else {?>
							<li><a href="<?php echo base_url(); ?>index.php/users"><span>Home</span></a>
						<?php } ?>
							</li>
						<?php $user_id = $this->session->userdata('user_id'); ?>
						<?php 
							if ($user_id)
							{
								$current_menu = $this->router->fetch_class().'/'.$this->router->fetch_method();
								$menus = $this->session->userdata('menus'); 
								foreach ($menus as $menu)
								{
									if ($current_menu === $menu->menu_page) {
										echo "<li class='menuselect'>";
										echo $menu->menu_title;
									}
									else {
										echo "<li>";
										echo anchor($menu->menu_page,$menu->menu_title);
									}
									
									echo "</li>";
								}
							}
						?>		
					</ul>
				</div>
			</div>
			<div id="breadcrumb">
				<h3><?php echo $bread_crumb; ?></h3>
				<span style="float:right;color:#C00;text-align:right;margin-top:-15px;margin-right:10px">
					<?php
						$err = $this->form_validation->first_error();
						if ($err == "")
						{
							$err = isset($error)?$error:"";
						}
					?>
					<?php echo $err;?>
				</span>
			</div>
		</div>
		<!--/header-->
	
		<!--content-->
		<?php if ($page != "") {$this->load->view($page);}?>
		<!--content-->
		
		<!--footer-->
		<!--	<div id="footer"> </div>-->
		<!--/footer-->
		
	</div>
	</body>
	
</html>
