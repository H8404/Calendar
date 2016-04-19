<div id="fade" class="blanket"></div>
<div id="editEvent" class="popUpDiv">
	<div class="closeDiv">
		<a href="javascript:;" onclick="Close()" class="close">X</a>
	</div>
	<form method="post" id="data" action="<?php echo $_SERVER['PHP_SELF'];?>" autocomplete="off">
		<div id="save">
			<input type="submit" name="SaveChanges" value="Save changes"/>
		</div>
	</form>
</div>
<?php
require_once('db-init.php');
$update = true;
if(isset($_POST['SaveChanges']) ){
	try{
		$id   = $_POST['editid'];
		$eDate = $_POST['editdate'];
		$eTitle = $_POST['editheader'];
		$eNote = $_POST['editnote'];
		$sql = "UPDATE event SET eventDate = :date, header = :header, note= :note WHERE ID = :id";
 
		$stmt = $db->prepare($sql);
		$stmt->execute(array($eDate, $eTitle, $eNote, $id));
		if($stmt){
			$curMonth = substr($eDate,5,2);
			$curYear = substr($eDate,0,4);
			$url = "http://student.labranet.jamk.fi/~H8404/calendar/index.php?month=".$curMonth."&year=".$curYear;
			echo "<script> location.href = '".$url."';</script>";
		}
	}                                                                                                             
	catch(PDOException $e)
	{
		echo $sql . "<br>" . $e->getMessage();
	}
}
?>