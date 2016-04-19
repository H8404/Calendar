<?php
	session_start();
	require_once('db-init.php');
	$day = $_POST['day'];
	$iduser = $_SESSION['userid'];
	$events = '';
	$sql = "SELECT ID, header, note
			FROM event
			WHERE users_id = :user AND eventDate = :event";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($iduser, $day));
	if ($stmt->rowCount() > 0){
		$events .= "<h2>".$day."</h2>";
		while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$title = $result["header"];
			$note = $result["note"];
			$id = $result['ID'];
			$events .= "<h3 class='sTitle'>".$title."</h3><p class='sNote'>".$note."</p><div><input type='submit' class='editEvent' id='$id' Value='Edit' onclick='javascript:Edit(this)'/><input type='submit' class='deleteEvent' id='$id' Value='Delete' onclick='javascript:Delete(this)'/></div>";
		}
	}
	echo $events;
?>
<div id="show" class="popUpDiv">
	<div class="closeDiv">
		<a href="javascript:;" onclick="Close()" class="close">X</a>
	</div>
	<div id="events">
	</div>
</div>
