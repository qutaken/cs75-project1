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
	$result = $sth->fetch(PDO::FETCH_ASSOC);
	if (isset($result["uid"]))
	{
		$dbh = null;
		return $result["uid"];
	}
	else
	{
		$error = "Username or password don't match.";
		return false;
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
function get_quote_data($symbol, &$error)
{
	if(!empty($symbol))
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
		if ($result["last_trade"] == 0.00)
		{
			$error = "No valid symbol was provided, or no quote data was found.";
		}
		return $result;
	}
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
	if (!$insert_stmt) 
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

function get_user_balance($userid, &$error)
{
	$dbh = connect_to_database();
	if (!$dbh) 
	{
		$error = 'could not connect to database';
		$dbh = null;
		return false;
	}
	$values = array('userid' => $userid);
	$stmt = prepare_query($dbh, "SELECT money FROM users WHERE uid=:userid", $values);
	if (!$stmt) 
	{
		$error = 'Not valid SQL statement #SELECT';
		return false;
	}
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if (isset($result['money']))
	{
		$dbh = null;
		return $result['money'];
	}
}

function buy_shares($userid, $symbol, $amount, &$error)
{
	if (!is_int($amount))
	{
		$error = 'Not a valid amount of that share.';
		return false;
	}
	// Here's where ALL the magic happens.
	$balance = get_user_balance($userid, $error);
	if (!$balance)
	{
		return false;
	}
	$data = get_quote_data($symbol, $error);
	if (isset($data['last_trade']) && $data['last_trade'] > 0.0)
	{
		extract($data);
		$total = $last_trade * $amount;
		$balance = get_user_balance($userid ,$error);
		if ($balance < $total)
		{
			$error = 'Sorry not enough money.(we\'re not a credit card company)';
			return false;
		}
		$dbh = connect_to_database();
		if (!$dbh)
		{
			$error = 'Could not connect to database.';
			return false;
		}
		try {
			$dbh->beginTransaction();
			$values = array('uid' => $userid, 'total' => $balance - $total, 'symbol' => $symbol, 'amount' => $amount);
			$update_money = prepare_query($dbh, "UPDATE users SET money=:total WHERE uid=:uid", $values);
			$update_money->execute();
			$select_stock = prepare_query($dbh, "SELECT symbol FROM portfolio WHERE uid=:uid AND symbol=:symbol", $values);
			$select_stock->execute();
			if ($select_stock->rowCount() < 1)
			{
				$insert_stock = prepare_query($dbh, "INSERT INTO portfolio 
					(uid, symbol, amount) VALUES (:uid, :symbol, :amount)", $values);
				$insert_stock->execute();
			}
			else
			{
				$update_stock = prepare_query($dbh, "UPDATE portfolio 
					SET amount=amount + :amount WHERE uid=:uid AND symbol=:symbol", $values);
				$update_stock->execute();
			}
			$dbh->commit();
			$dbh = null;

		} catch (PDOException $e) {
			$dbh->rollback();
			$dbh = null;
			$error = "problem with queries.";
			return false;
		}
		return true;
	}
	else
	{
		$error = "Not a valid stock symbol.";
		return false;
	}
		
}

function sell_shares($userid, $symbol, &$error) { }
