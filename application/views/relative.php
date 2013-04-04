<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open('relatives/'.$type); ?>
				<div class="formcontainer-lt">
					<table width="350" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>First Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="relative_id" value='<?php echo isset($relative)?$relative->id:set_value('relative_id'); ?>' />
									<input type="text" name="first_name" id="firstname" class="field-employe" value='<?php echo isset($relative)?$relative->first_name:set_value('first_name'); ?>' />
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Last Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="last_name" id="last_name" class="field-employe" value='<?php echo isset($relative)?$relative->last_name:set_value('last_name'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Relation</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="relation" id="dob" class="field-employe" value='<?php echo isset($relative)?$relative->relation:set_value('relation'); ?>' />
								</span>
							</td>
						</tr>
						<?php if ($role==3) {?>
						<tr>
							<td valign="top">
								<label style=" position:relative; top:7px;">Is Admin</label>
							</td>
							<td>
								<div style="position:relative; display:inline; width:209px; left:-5px; top:7px">
									<input type="checkbox" name="is_admin" <?php echo isset($relative)?($relative->is_admin?"checked":""):set_value('is_admin'); ?>/>
								</div>
							</td>
						</tr>
						<?php } else { ?>
						<input type="hidden" name="is_admin" value="0"/>
						<?php } ?>
					</table>
				</div>
				<div class="formcontainer-lt">
					<table width="350" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>User Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="user_id" id="url" class="field" value='<?php echo isset($user)?$user->id:set_value('user_id'); ?>'/>
									<input type="text" name="username" <?php echo ($type==='update')?'readonly="readonly"':''; ?> id="username" class="field-employe" value='<?php echo isset($user)?$user->username:set_value('username'); ?>' />
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Password</label></td>
							<td>
								<span class="field1-employe">
									<input type="password" name="password" id="password" class="field-employe" value='<?php echo isset($user)?$user->password:set_value('password'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Phone No</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="contact_id" id="url" class="field" value='<?php echo isset($contact)?$contact->id:set_value('contact_id'); ?>'/>
									<input type="text" name="phone" id="phone" class="field-employe" value='<?php echo isset($contact)?$contact->phone_no:set_value('phone'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Email</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="email" id="url" class="field-employe" value='<?php echo isset($contact)?$contact->email:set_value('email'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Address</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="address" id="url" class="field-employe" value='<?php echo isset($contact)?$contact->address:set_value('address'); ?>'/>
								</span>
							</td>
						</tr>
					</table>
				</div>
				<div style="float:left; background-color:#382015; width:125px; height:131px; margin-top:10px;"></div>
				<div style="clear:both"></div>
				<div style="background:#382015; padding:10px 0; margin-top:30px;">
					<input type="submit" name="login-btn" class="login-btn" value="Save" />
				</div>
			</form>			
		</div>  
	<div id="formshadow"></div>
</div>