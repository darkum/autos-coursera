<?php 
session_start();
require_once "pdo.php";
?>

<!DOCTYPE html>
<html>
<head>
	<title>Dinesh Kumar Kaveti - Automobile CRUD site</title>

	<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" 
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" 
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" 
    crossorigin="anonymous">

<link rel="stylesheet" 
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

</head>
<body>
	<div class="container">
		<h1>Welcome to our store</h1>

		<?php  
		if (!isset($_SESSION['email'])) {
			// echo "<h2>Please log in</h2>";
			echo "<p><a href=login.php>Please log in</a></p>";
		}
		else{

			if (isset($_SESSION['success'])) {
		        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
		        unset($_SESSION['success']);
		        // print_r($_SESSION);
		    }

			echo "<h2>Hello ".$_SESSION['email']."\n</h2><h3>Available cars:-</h3>";
			$getdata = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
			$rows = $getdata->fetchAll(PDO::FETCH_ASSOC);
			echo('<table border="1">'."\n");
			foreach ( $rows as $row ) {
    			echo "<tr><td>";
			    echo(htmlentities($row['make'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['model'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['year'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['mileage']))."\t";
			    echo("</td><td>");
			    echo('<a href="edit.php?autos_id='.$row['autos_id'].'">Edit</a> / ');
    			echo('<a href="delete.php?autos_id='.$row['autos_id'].'">Delete</a>');
    			echo("</td></tr>");
			}
			echo "<h2><a href=add.php>Add New Entry</a></h2>";
			echo "<h2><a href=logout.php>Logout</a></h2>";
		}
		?>
	</div>
</body>
</html>