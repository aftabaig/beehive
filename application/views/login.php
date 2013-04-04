<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bee Homes | Login</title>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<link href="<?php echo base_url(); ?>css/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.1.js"></script>
<script type="text/javascript" >
$(document).ready(function(){
    $("#forget").click(function(){
    $("#loginbox").fadeOut('slow', function(){$("#forgetbox").fadeIn('slow');});
  });
});
$(document).ready(function(){
    $("#goback").click(function(){
    $("#forgetbox").fadeOut('slow', function(){$("#loginbox").fadeIn('slow');});
  });
});
</script>
<script>
	$(document).ready(function() {
		$("#datepicker").datepicker();
	});
</script>
<!--[if IE 6]>
<script src="png/png-fix.js" type="text/javascript"></script>
<script src="png/png.js" type="text/javascript"></script>
<![endif]-->
</head>

<body>

<!--content-->
<div id="wrapper">
  <div id="content">
    <div id="login-col-1">
      <div style="margin-left:20px">
      <?php
		$err = $this->form_validation->first_error();
		if ($err == "")
		{
			$err = isset($error)?$error:"";
		}
	  ?>
	  <span style="color:#000;align:center">
	  <?php echo $err;?>
	  </span>
	  </div>
	  
      <div id="login-top"></div>
      <div id="login-mid">
        <ul id="loginbox">
          <li>
          	<?php echo form_open('users/authenticate'); ?>
              <label>User Name</label>
              <span class="field1">
              <input type="text" name="username" id="username" class="field" />
              </span>
              <label>Password</label>
              <span class="field1">
              <input type="password" name="password" id="pass" class="field"/>
              </span>
              <input type="submit" name="login-btn" class="login-btn" value="Login" />
              <label><a href="javascript:void(0)" id="forget">Forget Password</a></label>
            </form>
          </li>
        </ul>
        <ul id="forgetbox">
          <li>
            <form action="" name="forget-form" method="post">
              <label>Email</label>
              <span class="field1">
              <input type="text" name="email" id="email" class="field" />
              </span>
              <input type="submit" name="forget-btn" class="login-btn" value="Submit" />
              <label><a href="javascript:void(0)" id="goback">Go Back To Login !</a></label>
            </form>
          </li>
        </ul>
      </div>
      <div id="login-bot"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
  <!--/content-->
  <!--footer-->
  <!--  <div id="footer"> </div>-->
  <!--/footer-->
</div>
</body>
</html>
