<?php
/*********************************
 * model.php
 *
 * CSCI S-75
 * Project 1
 * Chris Gerber
 *
 * Model for users and portfolios
 *********************************/
	require_once("../includes/constants.php");
/*
 * login_user() - Verify account credentials and create session
 *
 * @param string $email
 * @param string $password
 */
function login_user($email, $password, &$error)
{
	$dbh = connect_to_database();
	if (!$dbh)
	{
		$error = "Could not connect to Database.";
		return false;
	}
	$values = array("email" => $email, "password" => hash("SHA1",$password));
	$sth = prepare_query($dbh, "SELECT uid FROM users WHERE LOWER(email)=:email AND password=:password",$values);
	if(!$sth)
	{
		$dbh = null;
		$error = "Incorrect SQL statement.";
		return false;
	}
	$sth->execute();
	echo "executed";
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	print_r($result);
	if (isset($result["uid"])) {
		$dbh = null;
		return $result["uid"];
	}
}


/*
 * get_user_shares() - Get portfolio for specified userid
 *
 * @param int $userid
 */
function get_user_shares($userid)
{
	// connect to database with PDO
	$dsn = 'mysql:host='.DB_HOST.';dbname='.DB_DATABASE;
	$dbh = new PDO($dsn, DB_USER, DB_PASSWORD);
	
	// get user's portfolio
	$stmt = $dbh->prepare("SELECT symbol, shares FROM portfolios WHERE userid=:userid");
	$stmt->bindValue(':userid', $userid, PDO::PARAM_STR);
	if ($stmt->execute())
	{
	    $result = array();
	    while ($row = $stmt->fetch()) {
			array_push($result, $row);
	    }
		$dbh = null;
		return $result;
	}
	
	// close database and return null 
	$dbh = null;
	return null;
}

/*
 * get_quote_data() - Get Yahoo quote data for a symbol
 *
 * @param string $symbol
 */
function get_quote_data($symbol)
{
	$result = array();
	$url = "http://download.finance.yahoo.com/d/quotes.csv?s={$symbol}&f=sl1n&e=.csv";
	$handle = fopen($url, "r");
	if ($row = fgetcsv($handle))
		if (isset($row[1]))
			$result = array("symbol" => $row[0],
							"last_trade" => $row[1],
							"name" => $row[2]);
	fclose($handle);
	return $result;
}

/*
 * register_user() - Create a new user account
 *
 * @param string $email
 * @param string $password
 * 
 * @return string $error
 */
function register_user($email, $password, &$error)
{
	$dbh = connect_to_database();
	if (!$dbh) 
	{
		$error = 'could not connect to database';
		$dbh = null;
		return false;
	}
	$values = array('email' => $email, 'password' => hash('SHA1', $password));
	$select_stmt = prepare_query($dbh, "SELECT * FROM users WHERE email=:email", $values);
	if (!$select_stmt) 
	{
		$error = 'Not valid SQL statement #SELECT';
		return false;
	}
	$insert_stmt = prepare_query($dbh, "INSERT INTO users (email, password, money) VALUES (:email, :password, 10000)", $values);
	if (!$select_stmt) 
	{
		$error = 'Not valid SQL statement #INSERT';
		return false;
	}
	$dbh->beginTransaction();
	$select_stmt->execute();
	if ($select_stmt->rowCount() < 1) 
	{
		$insert_stmt->execute();
		$dbh->commit();
		$dbh = null;
		return true;
	}
	else
	{
		$dbh->rollback();
	    $error = 'Your seem to have already been registered.';
	    return false;
	}
}

function get_user_balance($userid) { }

function buy_shares($userid, $symbol, $shares, &$error) { }

function sell_shares($userid, $symbol, &$error) { }
