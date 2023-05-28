<?php
	session_start();
	//print_r($_POST);

$errors = [];
foreach ($_POST as $key => $value){
	if (empty($value)){
		$errors[] = "Pole <b>$key</b> jest wymagane";
	}
}

if (!empty($errors)){
	$_SESSION["error_message"] = implode("<br>", $errors);
	echo "<script>history.back();</script>";
	exit();
}

try{
	require_once "./connect.php";
	$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
	$stmt->bind_param('s', $_POST["login"]);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows){
		$user = $result->fetch_assoc();
		if (password_verify($_POST["pass"], $user["password"])){
			$_SESSION["logged"]["firstName"] = $user["firstName"];
			$_SESSION["logged"]["lastName"] = $user["lastName"];
			$_SESSION["logged"]["session_id"] = session_id();
			header("location: ../pages/view/logged.php");
		}else{
			$_SESSION["error_message"] = "Błędny login lub hasło!";
			echo "<script>history.back();</script>";
			echo "error";
			exit();
		}
	}else{
		$_SESSION["error_message"] = "Błędny login lub hasło!";
		echo "<script>history.back();</script>";
		echo "error";
		exit();
	}
} catch(mysqli_sql_exception $e)
{
	$_SESSION["error_message"] = $e->getMessage();
	echo "<script>history.back();</script>";
	exit();
}

