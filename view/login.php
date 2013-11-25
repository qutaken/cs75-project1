<form id="form" method="POST" action="login" onsubmit="return validateLoginForm();">
	<div class="field text">
    	<label for="inputEmail">Email</label>
      	<input type="text" id="inputEmail" name="email" placeholder="Email">
    </div>
    <div class="field text">
    	<label for="inputPassword">Password</label>
      	<input type="password" id="inputPassword" name="password" placeholder="Password">
	</div>
	<div class="field text">
      	<input type="submit" value="Login">
	</div>
</form>
<div class="field text" id="register_div">
		<label for="register">Not registered?</label>
	<a href="register/" id="register">Register here</a>
</div>

<script type='text/javascript'>
// <! [CDATA[

function validateLoginForm()
{
	isValid = true;
	
	// check if the email address was entered (min=6: x@x.to)
	emailField = $("input[name=email]");
	if (emailField.val().length < 6)
		isValid = false;
		
	return isValid;
}

// set the focus to the email field (located by id attribute)
$("input[name=email]").focus();

// ]] >
</script>