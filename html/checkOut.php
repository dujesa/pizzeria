<?php
	session_start();

	//enters if user submited remove item button
	if (isset ($_POST['removeItem']) )
	{
		//displays which item was removed
		$i = $_POST['itemToRemove'];
		echo $_SESSION['ordered'][$i]['name'] . ' removed from order.';
		//subtracts cost of removed item from total cost of order
		$_SESSION['cost'] -= $_SESSION['ordered'][$_POST['itemToRemove']]['price'];
		//removes item from order
		unset ($_SESSION['ordered'][$_POST['itemToRemove']]);
	}


	//if user aproached without ordering anything or if removes all items from order
	if ($_SESSION['cost'] == 0)
	{
		//redirect to start page
		header('Location: index.php');
	}

	//order display
	echo '<h1>Your order</h1>';
	foreach ($_SESSION['ordered'] as $index => $value) 
	{
		echo '<form action = "" method = "post">';
		echo $_SESSION['ordered'][$index]['name'] . '.....' . $_SESSION['ordered'][$index]['price']/100.0 . '$ &emsp;&emsp;';
		//enters if user hadnt yet accepted order and provides removing single items from order
		if(!isset($_POST['acceptOrder']))
		{
				echo '<input type = "submit" name = "removeItem" value = "Remove from order">';
				echo '<input type="hidden" name="itemToRemove" value="' . $index  . '"/>';
		}
		echo '</form></br>';
	}
	//full order price
	echo '<h2>Total: </h2>' . $_SESSION['cost']/100.0 . '$';
	//enters if user hadnt yet accepted order
	if(!isset($_POST['acceptOrder']))
	{
			echo '<form action = "" method = "post">';
			echo '<input type = "submit" name = "acceptOrder" value = "Accept order">';
			echo '</form>';
	}			
?>