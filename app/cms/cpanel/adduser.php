<script type="text/javascript">
// this is where we define the role that a user will have
function role_description(object){
    var description = "standard";
    if(object.value == 'standard')
  	  description = "A standard user will be able to post stories. However, the standard user can only edit stories published under their own username. Other posts are off limits.";
    if(object.value == 'administrator')
      description = "Administrators have full access to all stories and pages. This includes adding, editing, and deleting stories published by anyone.";
    if(object.value == '')
      description = "You are unable to continue until you select a role for the new user.";
    document.getElementById('role_description').innerHTML = description;
}
</script>
<form name="adduser_form" method="post" action="./scripts/newuser.php">
<table><tr><td class="right">Role:</td><td>
<select name="roleMenu" id="roleMenu" onchange="role_description(this)">
  <option></option>
  <option>standard</option>
  <option>administrator</option>
</select></td></tr>
<tr><td class="right">&nbsp;</td><td><div id='role_description'>You are unable to continue until you select a role for the new user.</div></td></tr>
<tr><td colspan="2"><fieldset>Select systems the user will have access to:<br /><label><input type="checkbox" name="system[]" value="lvs_standard" />Lunch Voting System | Standard</label><br />
<label><input type="checkbox" name="system[]" value="lvs_admin" />Lunch Voting System | Admin</label> </fieldset></td></tr>
<tr><td class="right">Username:</td><td><input type="text" name="username" /></td></tr>
<tr><td class="right">Password:</td><td><input type="password" name="password" /></td></tr>
<tr><td class="right">Repeat Password:</td><td><input type="password" name="confirm" /></td></tr>
<tr><td class="right">&nbsp;</td><td><input type="submit" value="Create User" /></td></tr>
</table>
</form>