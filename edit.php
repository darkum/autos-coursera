<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email']) ) {
	die("ACCESS DENIED");
}

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
    return;
}



if (isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage']) ) {
	echo "string";
	if(strlen($_POST['make'])<1|| strlen($_POST['model'])<1|| strlen($_POST['year'])<1|| strlen($_POST['mileage'])<1)
	{

		$_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
  		return;
	}
	elseif (!is_numeric($_POST['year']) ) {
		$_SESSION['error'] = "Year must be an integer";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
 		 return;
	}
	elseif (!is_numeric($_POST['mileage'])) {
		$_SESSION['error'] = "Mileage must be an integer";
        header("Location: edit.php?autos_id=".$_REQUEST['autos_id']);
  		return;
	}
	else{

		unset($_SESSION['make']);
		unset($_SESSION['model']);
		unset($_SESSION['year']);
		unset($_SESSION['mileage']);
		// unset($_SESSION['autos_id']);
		$_SESSION['make'] = $_POST['make'];
		$_SESSION['model'] = $_POST['model'];
		$_SESSION['year'] = $_POST['year'];
		$_SESSION['mileage'] = $_POST['mileage'];
		// $_SESSION['autos_id'] = $_POST['autos_id'];

		$sqlstmt = "UPDATE autos SET make = :mk, model = :md, year = :yr, mileage = :mi WHERE autos_id = :autos_id";
		$stmt = $pdo->prepare($sqlstmt);
		$stmt->execute(array(
		        ':mk' => $_POST['make'],
		        ':md' => $_POST['model'],
		        ':yr' => $_POST['year'],
		        ':mi' => $_POST['mileage'],
		    	':autos_id' => $_GET['autos_id']));
		$_SESSION['success'] = "Record edited";
		header("Location: index.php");
		return;
	}
}

if ( ! isset($_GET['autos_id']) ) {
	$_SESSION['error'] = "Missing autos_id";
  	header('Location: index.php');
  	return;
}

$stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :autos_id");
$stmt->execute(array(":autos_id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for autos_id';
    header( 'Location: index.php' ) ;
    return;
}

$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$autos_id = $row['autos_id'];



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
		
		<?php
		    if (isset($_SESSION['error'])) {
		        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
		        unset($_SESSION['error']);
		    }
		?>
		<h1>Edit</h1>
		<form method="post">
			<p>Make:
				<input type="text" name="make" value="<?= $make ?>"></p>
			<p>Model:
				<input type="text" name="model" value="<?= $model ?>"></p>
			<p>Year:
				<input type="text" name="year" value="<?= $year ?>"></p>
			<p>Mileage:
				<input type="text" name="mileage" value="<?= $mileage ?>"></p>
			<p>
				<input type="hidden" name="autos_id" value="<?= $autos_id ?>"></p>
			<p>
				<input type="submit" value="Save" ></p>
			<p>
				<input type="submit" value="Cancel" name="cancel"></p>
		</form>
		<!-- <p><a href="index.php">Cancel</a></p> -->
	</div>
</body>
</html>