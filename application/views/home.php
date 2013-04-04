<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open('homes/'.$type); ?>
				<div id="formcontainer">
					<table width="550" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>Home Name:</label></td>
							<td>
								<span class="field1">
									<input type="hidden" name="home_id" value='<?php echo isset($home)?$home->id:set_value('home_id'); ?>' />
									<input type="text" name="home_name" id="name" class="field" value='<?php echo isset($home)?$home->home_name:set_value('home_name'); ?>' />
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Phone No:</label></td>
							<td>
								<span class="field1">
									<input type="hidden" name="contact_id" id="url" class="field" value='<?php echo isset($contact)?$contact->id:set_value('contact_id'); ?>'/>
									<input type="text" name="phone_no" id="url" class="field" value='<?php echo isset($contact)?$contact->phone_no:set_value('phone_no'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Email:</label></td>
							<td>
								<span class="field1">
									<input type="text" name="email" id="url" class="field" value='<?php echo isset($contact)?$contact->email:set_value('email'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Address:</label></td>
							<td>
								<span class="field1">
									<input type="text" name="address" id="url" class="field" value='<?php echo isset($contact)?$contact->address:set_value('address'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Username:</label></td>
							<td>
								<span class="field1">
									<input type="hidden" name="user_id" id="url" class="field" value='<?php echo isset($user)?$user->id:set_value('user_id'); ?>'/>
									<input type="text" <?php echo ($type==='update')?'disabled':''; ?> name="username" id="url" class="field" value='<?php echo isset($user)?$user->username:set_value('username'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Password:</label></td>
							<td>
								<span class="field1">
									<input type="password" name="password" id="url" class="field" value='<?php echo isset($user)?$user->password:set_value('password'); ?>'/>
								</span>
							</td>
						</tr>
					</table>
				</div>
				<div style="background:#382015; padding:10px 0; margin-top:50px;">
					<input type="submit" name="login-btn" class="login-btn" value="Save" />
				</div>
			</form>
		</div>
		<div id="formshadow"></div>
	</div>