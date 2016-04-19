<?php
	require_once('db-init.php');
	$id = $_POST['id'];
	$sql = "SELECT eventDate, header, note
			FROM event
			WHERE ID = :id";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($id));
	if ($stmt->rowCount() > 0){
		$result = $stmt -> fetch();
		$date = $result['eventDate'];
		$title = $result['header'];
		$note = $result['note'];
		$events .= "<div class='text'><p>Date: </p><p>Title: </p><p>Note: </p></div><div class='textfield'>
		<div><input type='text' style='display:none;' name='editid' value='$id'></div><div><input type='text' name='editdate' value='$date'/></div><div><input type='text' name='editheader' value='$title'/></div><div><textarea class='note' rows='6' cols='40' name='editnote'>$note</textarea></div></div>";
	}
	echo $events;
?>
