<?php
require_once('../includes/helper.php');
render('header', array('title' => 'C$75 Finance'));
?>
<div id="container">
	<div id="frame">
		<h2 id="header" style="font-family:sans-serif;">Register</h2>
		<form id="form" method="POST" action="/register" onsubmit="return validateForm();">
			<div class="field text">
		    	<label for="inputEmail">Email</label>
		      	<input type="text" id="inputEmail" name="email" placeholder="Email">
		    </div>
		    <div class="field text">
		    	<label for="inputPassword">Password</label>
		      	<input type="password" id="inputPassword" name="password" placeholder="Password">
			</div>
			<div class="field text">
		    	<label for="inputPassword">Retype Password</label>
		      	<input type="password" id="inputPassword" name="re_password" placeholder="Password">
			</div>
			<div class="field text">
		      	<input type="submit" value="Register">
	    	</div>
		</form>
	</div>
	<?php 
	if (isset($error))
		echo "<p>{$error}<p/>"; 
	?>
</div>

<script type='text/javascript'>
// <! [CDATA[

function validateForm()
{
	isValid = true;
	
	// check if the email address was entered (min=6: x@x.to)
	emailField = $("input[name=email]");
	password = $("input[name=password]");
	re_password = $("input[name=re_password]");
	if (emailField.val().length < 6)
		isValid = false;
	else if (password.length() < 7)
		isValid = false;
	else if (!password.match(/((^[0-9]+[a-z]+)|(^[a-z]+[0-9]+))+[0-9a-z]+$/i))
		isValid = false;
	else if (password.localeCompare(re_password)
		isValid = false;

	return isValid;
}

// set the focus to the email field (located by id attribute)
$("input[name=email]").focus();

// ]] >
</script>

<?php
render('footer');
?>
