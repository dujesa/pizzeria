<!DOCTYPE html>
<html>
<head>
	<title>Menu</title>
</head>
<body>

	<?php
		//start session if not exists
		if(!isset($_SESSION)) 
	    { 
	        session_start();
	        
	    }

		//call to function which loads menu in associative array 
		$xml = loadMenu();

		//enters if user submited checkout button
		if (isset ($_POST['checkOutSubmit']))
		{
			//set total cart price to 0 after users submitted
			$_SESSION['cost'] = 0; 

			//loop through user selected items
			foreach($_POST['products'] as $index => $product)
			{
				//transforming string from post superglobal to format for XPath
				$explodedProductName = explode(', ', $product);
				$xPathQuery = '//' . implode('/', $explodedProductName);
				//XPath querying for price of selected element
				$queryResult = $xml -> xpath($xPathQuery)[0];
				//call to function that adds selected items to session array
				addToCart ($product, (int)$queryResult);
			}	
			
			//redirection to checkout page	
			header('Location: /checkOut.php');

		}
		else
		{
			//enters this block of code if user didnt aproached by submitting checkout
			session_unset();
			session_destroy();
		}

		//creating form to send selected and submitted data
		echo '<form action = "" method = "post">';
		//loop for display all food main categories
		foreach ($xml as $foodCategory => $value) 
		{
			//rendering one category, and nesting items in it
			print '<ul>--' . $foodCategory . '--</ul>' ;
			//loop for display subcategories
			foreach ($value as $foodSubcategory => $price) 
			{

				if ($price > 0)
				{
					//filling buffer with full name of food, later for XPath
					$buffer = $foodCategory . ', ' . $foodSubcategory ;

					?>

					<!--rendering item with two depths-->
					<li>	
					<input type = "checkbox" name = "products[]" value = "<?php echo $buffer ?>"><?php echo $buffer . '.....' . $price/100.0;?><br>
							
					<?php
				}
				else
				{

					foreach ($price as $subCatName => $subCatSpecies)
					{
						//filling buffer with full name of food, later for XPath
						$buffer = $foodCategory . ', ' . $foodSubcategory . ', ' . $subCatName ;

						?>

						<!--rendering items with three depths-->
						<li>	
						<input type = "checkbox" name = "products[]" value = "<?php echo $buffer ?>"><?php echo $buffer . '.....' . $subCatSpecies/100.0;?><br>
									
						<?php

						//flushing a buffer		
						$buffer = '';
					}
				}	

						?>

				</li>

				<?php			
			}
		}

		//displaying button which triggers procces of storing selected food in cart
		echo '<input type = "submit" value = "Check Out" name = "checkOutSubmit">';
		echo '</form>';

	?>
</body>
</html>