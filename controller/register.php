<?php
/*******************
 * quote.php
 *
 * CSCI S-75
 * Project 1
 * Velvel Marasow
 *
 * Register controller
 *******************/
require_once('../model/model.php');
require_once('../includes/helper.php');

// validate user input
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["re_password"]))
{
	if (!validate_form($_POST['email'], $_POST['password'], $_POST['re_password'], $error))
	{
		render('register', array('error' => $error));
	}
	else
	{	
		$email = $_POST["email"]; $password = $_POST["password"];
		$password = hash("SHA1", $password);
		// function declaration is in model does all the error checking there and returns it in the error var.
		$registered = register_user($email, $password, $error);
		if (!$registered)
		{
			render('register', array('error' => $error));
		}
		else
		{
			render('login');	
		}
	}
}
else
{
	render('register');
}