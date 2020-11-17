<?php
require_once "pdo.php";
session_start();

if ( ! isset($_SESSION['email']) ) {
	die("ACCESS DENIED");
}


if (isset($_POST['del'])) {
	// echo "string";

	if (strlen($_POST['make'])<1|| strlen($_POST['model'])<1|| strlen($_POST['year'])<1
	|| strlen($_POST['mileage'])<1) {

		$_SESSION['error'] = "All fields are required";
        header("Location: edit.php?autos_id=".$_REQUEST['id']);
  		return;
	}
	elseif (!is_numeric($_POST['year']) ) {
		$_SESSION['error'] = "Year must be an integer";
        header("Location: edit.php?autos_id=".$_REQUEST['id']);
 		 return;
	}
	elseif (!is_numeric($_POST['mileage'])) {
		$_SESSION['error'] = "Mileage must be an integer";
        header("Location: edit.php?autos_id=".$_REQUEST['id']);
  		return;
	}
	else{

		// unset($_SESSION['make']);
		

		$sqlstmt = "DELETE FROM autos WHERE autos_id = :autos_id";
		$stmt = $pdo->prepare($sqlstmt);
		$stmt->execute(array(':autos_id' => $_GET['autos_id']));
		$_SESSION['success'] = "Record deleted";
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

if ( isset($_POST['cancel']) ) {
    header('Location: index.php');
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
		
		<?php
		    if (isset($_SESSION['error'])) {
		        echo('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
		        unset($_SESSION['error']);
		    }
		?>
		<h1>Do you want to delete automobile - </h1>
		<!-- <table border="1">
			<tr>
				<td>"<?= $make   ?>"</td>
				<td>"<?= $model  ?>"</td>
				<td>"<?= $year   ?>"</td>
				<td>"<?= $mileage?>"</td>
			</tr>
		</table> -->
		<!-- echo('<table border="1">'."\n");
			foreach ( $rows as $row ) {
    			echo "<tr><td>";
			    echo(htmlentities($row['make'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['model'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['year'])."\t");
			    echo("</td><td>");
			    echo(htmlentities($row['mileage']))."\t";
			    echo("</td></tr>"); -->
		<form method="post">
			<p>Make:
				<input type="text" name="make" value="<?= $make ?>"></p>
			<p>Model:
				<input type="text" name="model" value="<?= $model ?>"></p>
			<p>Year:
				<input type="text" name="year" value="<?= $year ?>"></p>
			<p>Mileage:
				<input type="text" name="mileage" value="<?= $mileage ?>"></p>
			<input type="hidden" name="autos_id" value="<?= $autos_id ?>">
			<p><input type="submit" value="Delete" name="del"></p>
			<p><input type="submit" value="Cancel" name="cancel"></p>
		</form>
	</div>
</body>
</html>