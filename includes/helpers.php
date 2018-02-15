<?php

	//start session if not exists
	if(!isset($_SESSION)) 
	{ 
	    session_start(); 
	    $_SESSION['cost'] = 0;
	}

	//loading the menu from xml to simplexml object
	function loadMenu ()
	{
		return simplexml_load_file("../includes/menu.xml");
	}

	//loading cart to session
	function addToCart ($food, $price)
	{
		//setting food data through array to session
		$foodNPrice['name'] = $food;
		$foodNPrice['price'] = $price;
		$_SESSION['ordered'][]  = $foodNPrice;

		//adding a price of food to price of cart
		$_SESSION['cost'] += $price;
	}

?>