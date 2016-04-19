<?php
	require_once('db-init.php');
	$id = $_POST['id'];
	$events = '';
	$sql = "DELETE FROM event WHERE ID = :id";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($id));
	if ($stmt->rowCount() == 1){
		echo "Event was successfully removed.";
	}
?>