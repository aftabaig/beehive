<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open('employees/'.$type); ?>
				<div class="formcontainer-lt">
					<table width="350" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>First Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="employee_id" value='<?php echo isset($employee)?$employee->id:set_value('employee_id'); ?>' />
									<input type="text" name="first_name" id="firstname" class="field-employe" value='<?php echo isset($employee)?$employee->first_name:set_value('first_name'); ?>' />
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Middle Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="middle_name" id="middle-name" class="field-employe" value='<?php echo isset($employee)?$employee->middle_name:set_value('middle_name'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Last Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="last_name" id="last_name" class="field-employe" value='<?php echo isset($employee)?$employee->last_name:set_value('last_name'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>D.O.B</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="dob" id="dob" class="field-employe" value='<?php echo isset($employee)?$employee->dob:set_value('dob'); ?>' />
								</span>
							</td>
						</tr>
						<tr>
							<td valign="top">
								<label style=" position:relative; top:7px;">Gender</label>
							</td>
							<td>
								<div style="position:relative; display:inline; width:209px; left:-5px;">
									<select name="gender" class="select" title="Male">
										<option>Male</option>
										<option>Female</option>
									</select>
								</div>
							</td>
						</tr>
						<tr>
							<td><label>Job Title</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="job_title" id="job-title" class="field-employe" value='<?php echo isset($employee)?$employee->job_title:set_value('job_title'); ?>' />
								</span>
							</td>
						</tr>
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