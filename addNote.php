<?php
function validateDate($date, $format = 'Y-m-d H:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
require_once('db-init.php');
session_start();
$userid = $_SESSION['userid'];
$curMonth = "";
$curYear = "";
if(isset($_GET['Save'])){
	$checkDate = $_GET['date'];
	$checkTitle = $_GET['header'];
	if(validateDate($checkDate, 'Y-m-d') == true){
		if($checkTitle == ""){
			echo '<script>document.getElementById("message").innerHTML = "Title can not be empty!"</script>';
		}else{
			$sql = "SELECT * FROM event WHERE eventdate = :date AND header = :header AND users_id = :user";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':date', $checkDate);
			$stmt->bindParam(':header', $checkTitle);
			$stmt->bindParam(':user', $userid);
			$stmt->execute();
			if ($stmt->rowCount() <= 0){
				try{
					$date   = isset($_REQUEST['date'])   ? $_REQUEST['date']   : '';
					$header = isset($_REQUEST['header']) ? $_REQUEST['header'] : '';
					$note  = isset($_REQUEST['note'])  ? $_REQUEST['note']  : '';
					$sql2 = "INSERT INTO event (eventdate,header,note,users_id) VALUES(:f1,:f2,:f3,:f4)";
					$curMonth = substr($date,5,2);
					$curYear = substr($date,0,4);
					$stmt2 = $db->prepare($sql2);
					$stmt2->execute(array(':f1' => $date, ':f2' => $header, ':f3' => $note, ':f4' => $userid));
					if($stmt2){
						$url = "http://student.labranet.jamk.fi/~H8404/calendar/index.php?month=".$curMonth."&year=".$curYear;
						echo "<script> location.href = '".$url."';</script>";
					}
				}
				catch(PDOException $e)
				{
					echo $sql . "<br>" . $e->getMessage();
				}
			}
		}
	}
	else{
		echo '<script>document.getElementById("message").innerHTML = "Your date is invalid!"</script>';
	}
}
?>
<div id="fade" class="blanket"></div>
<div id="light" class="popUpDiv">
	<div class="closeDiv">
		<a href="javascript:;" onclick="Close()" class="close">X</a>
	</div>
	<form method="get" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
		<div class="text">
			<p>Date: </p>
			<p>Title: </p>
			<p>Note: </p>
		</div>
		<div class="textfield">
			<div>
				<input id="addNoteDate" type="text" name="date"/>
			</div>
			<div>
				<input type="text" name="header"/>
			</div>
			<div>
				<textarea class="note" rows="6" cols="40" name="note"></textarea>
			</div>	
		</div>
		<div id="save">
			<input type="submit" name="Save" value="Save"/>
		</div>
	</form>
</div>


