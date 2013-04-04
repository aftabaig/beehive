<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open('push/send_notification'); ?>
				<div id="formcontainer">
					<table width="550" border="0" align="center" cellspacing="7">
						<tr>
							<td><label style="position:relative; top:-60px;">Message</label></td>
							<td>
								<span class="textarea1">
									<textarea name="message" class="field" id="location" style="width:395px; height:79px; line-height:20px; resize:none;"></textarea>
								</span>
							</td>
						</tr>
					</table>
				</div>
				<div style="background:#382015; padding:10px 0; margin-top:50px;">
					<input type="submit" name="login-btn" class="login-btn" value="Send" />
				</div>
			</form>
		</div>
		<div id="formshadow"></div>
	</div>
