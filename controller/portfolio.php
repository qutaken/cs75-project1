<?php
/*********************
 * portfolio.php
 *
 * CSCI S-75
 * Project 1
 * Chris Gerber
 *
 * Portfolio controller
 *********************/

require_once('../model/model.php');
require_once('../includes/helper.php');

if (isset($_SESSION['userid']))
{
	// get the list of holdings for user
	$userid = (int)$_SESSION['userid'];
	$holdings = get_user_shares($userid, $error);
	$balance = get_user_balance($userid, $error);

	$current_prices = array();
	// Initialize the string for the URL for Yahoo Finance
	// and get the amount of each share from the Database.
	$symbols = '';
	foreach ($holdings as $value)
	{
		$symbols .= $value["symbol"] . '+';
		$current_prices[$value['symbol']] = $value['amount'];;
	}

	$symbols = get_quote_data(urlencode($symbols), $error);
	// get the current price of each stock in portfolio
	// and total value of the amount of each stock in portfolio
	$total = 0;
	foreach ($symbols as $stock)
	{
		$amount = $current_prices[$stock['symbol']];
		$current_prices[$stock['symbol']] = array($stock['last_trade'], $stock['last_trade'] * $amount);
		$total += $current_prices[$stock['symbol']][1];
		echo "<pre>"; print_r($current_prices); echo "</pre>";
	}
	// send all the data to the template
	render('template', array('view' => 'portfolio', 'title' => 'Portfolio', 'header' => 'Portfolio', 
		'data' => array('holdings' => $holdings, 'balance' => $balance, 'prices' => $current_prices, 'total' => $total), 
		'error' => $error));
}
else
{
	render('template', array('view' => 'login', 'title' => 'Login', 'header' => 'Log in'));
}
?>
