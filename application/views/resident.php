<div id="wrapper">
	<div id="content">
		<div id="formbg">
			<?php echo form_open('residents/'.$type); ?>
				<div class="formcontainer-lt">
					<table width="350" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>First Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="resident_id" value='<?php echo isset($resident)?$resident->id:set_value('resident_id'); ?>' />
									<input type="text" name="first_name" id="firstname" class="field-employe" value='<?php echo isset($resident)?$resident->first_name:set_value('first_name'); ?>' />
								</span>
							</td>
						</tr>
							<td><label>Middle Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="middle_name" id="middle-name" class="field-employe" value='<?php echo isset($resident)?$resident->middle_name:set_value('middle_name'); ?>'/>
								</span>
							</td>
						</tr>
							<td><label>Last Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="last_name" id="last_name" class="field-employe" value='<?php echo isset($resident)?$resident->last_name:set_value('last_name'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>D.O.B</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="dob" id="datepicker" class="field-employe" value='<?php echo isset($resident)?$resident->dob:set_value('dob'); ?>' />
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
							<td><label>Nick Name</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="nick_name" id="nick-name" class="field-employe" value='<?php echo isset($resident)?$resident->nick_name:set_value('nick_name'); ?>' />
								</span>
							</td>
						</tr>
					</table>
				</div>
				<div class="formcontainer-lt">
					<table width="350" border="0" align="center" cellspacing="7">
						<tr>
							<td><label>Room No.</label></td>
							<td>
								<span class="field1-employe">
									<input type="text" name="room_no" id="room_no" class="field-employe" value='<?php echo isset($resident)?$resident->room_no:set_value('room_no'); ?>'/>
								</span>
							</td>
						</tr>
						<tr>
							<td><label>Phone No</label></td>
							<td>
								<span class="field1-employe">
									<input type="hidden" name="contact_id" id="url" class="field" value='<?php echo isset($contact)?$contact->id:set_value('contact_id'); ?>'/>
									<input type="text" name="phone_no" id="phone_no" class="field-employe" value='<?php echo isset($contact)?$contact->phone_no:set_value('phone_no'); ?>'/>
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