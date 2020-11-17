<?php 
session_start();
require_once "pdo.php";

if ( ! isset($_SESSION['email']) ) {
	die("ACCESS DENIED");
}
if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}
if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year'])  && isset($_POST['mileage']) ) {

	if(strlen($_POST['make'])<1|| strlen($_POST['model'])<1|| strlen($_POST['year'])<1|| strlen($_POST['mileage'])<1)
	{
		$_SESSION['error'] = "All fields are required";
	  	header("Location: add.php");
	  	return;
	}
	elseif (!is_numeric($_POST['year']) ) {
		$_SESSION['error'] = "Year must be an integer";
        header("Location: add.php");
        return;
	}
	elseif (!is_numeric($_POST['mileage'])) {
		$_SESSION['error'] = "Mileage must be an integer";
        header("Location: add.php");
        return;
	}
	else{

		unset($_SESSION['make']);
		unset($_SESSION['model']);
		unset($_SESSION['year']);
		unset($_SESSION['mileage']);
		
		$_SESSION['make'] = $_POST['make'];
		$_SESSION['model'] = $_POST['model'];
		$_SESSION['year'] = $_POST['year'];
		$_SESSION['mileage'] = $_POST['mileage'];

		$stmt = $pdo->prepare('INSERT INTO autos
		        (make, model, year, mileage) VALUES ( :mk, :md, :yr, :mi)');
		$stmt->execute(array(
		        ':mk' => $_SESSION['make'],
		        ':md' => $_SESSION['model'],
		        ':yr' => $_SESSION['year'],
		        ':mi' => $_SESSION['mileage']));
		$_SESSION['success'] = "Record added";
		header("Location: index.php");
		return;
	}
}

if ( isset($_POST['logout']) ) {
    header('Location: logout.php');
    return;
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Dinesh Kumar Kaveti</title>
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
		<h1>Welcome to Autos plaza </h1>
		<?php
		    if (isset($_SESSION['error'])) {
		        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
		        unset($_SESSION['error']);
		    }
		?>
		<form method="post">
			<p>Make:
				<input type="text" name="make"></p>
			<p>Model:
				<input type="text" name="model"></p>
			<p>Year:
				<input type="text" name="year"></p>
			<p>Mileage:
				<input type="text" name="mileage"></p>
			<p><input type="submit" value="Add"/></p>
			<p><input type="submit" value="Cancel" name="cancel"></p>
		</form>
	</div>
</body>
</html>