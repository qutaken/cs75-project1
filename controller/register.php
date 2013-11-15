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

if (isset($_POST["email"]) && isset($_POST["password"]))
{
	$email = $_POST["email"]; $password = $_POST["password"];
	/*
	 * validate the email
	 * hash the password
	 * start a transaction 
	 */
	validate_email($email);
	$password = hash("SHA1", $password);
	$dbh = connect_to_database();
}
else
{
	render('register');
}
echo "Hello World we are under construction.";