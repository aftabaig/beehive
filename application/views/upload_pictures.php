<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open_multipart('pictures/do_upload'); ?>
				<div id="formcontainer">
					<table width="650" border="1" align="center" cellspacing="7">
						<tr>
							<td><label>To</label></td>
							<td>
								<?php echo form_dropdown('relative_id',$relatives,$selected); ?>
							</td>
						</tr>
						<tr>
						<td></td>
						<td>
							<?php echo form_upload('userfile1') ?>
							<?php echo form_upload('userfile2') ?>
							<?php echo form_upload('userfile3') ?>
							<?php echo form_upload('userfile4') ?>
							<?php echo form_upload('userfile5') ?>
						</td>
					</table>
				</div>
				<div style="background:#382015; padding:10px 0; margin-top:50px;">
					<input type="submit" name="login-btn" class="login-btn" value="Upload" />
				</div>
			</form>
		</div>
		<div id="formshadow"></div>
	</div>