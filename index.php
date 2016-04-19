<!DOCTYPE html>
<?php
session_start();
require_once('db-init.php');
//Tämän päivän päivä
$date = time();

//Erottaa päivät, kuukaudet ja vuodet
$day = date('d', $date) ;
$month = (int) ($_GET['month'] ? $_GET['month'] : date('m'));
$year = (int)  ($_GET['year'] ? $_GET['year'] : date('Y'));

//Kuukauden ensimmäinen päivä
$first_day = mktime(0,0,0,$month, 1, $year) ;

//Kuukauden nimi
$title = date('F', $first_day) ;

//Mikä viikonpäivä on kuukauden eka päivä
$day_of_week = date('D', $first_day) ;     

//Kuinka monta "tyhjää" päivää tarvitaan ennen ensimmäistä päivää
switch($day_of_week)
{   
	case "Mon": $blank = 0; break;   
	case "Tue": $blank = 1; break;   
	case "Wed": $blank = 2; break;   
	case "Thu": $blank = 3; break;   
	case "Fri": $blank = 4; break;   
	case "Sat": $blank = 5; break;   
	case "Sun": $blank = 6; break;   
}    

//Kuinka monta päivää kuukaudessa on
$days_in_month = cal_days_in_month(0, $month, $year) ; 

//Seuraava kuukasi
$next_month_link = '<a href="?month='.($month != 12 ? $month + 1 : 1).'&year='.($month != 12 ? $year : $year + 1).'" class="forward"> >> </a>';

//Edellinen kuukausi
$previous_month_link = '<a href="?month='.($month != 1 ? $month - 1 : 12).'&year='.($month != 1 ? $year : $year - 1).'" class="backward" > << </a>';



?>
<html>
	<head>
		<link href='https://fonts.googleapis.com/css?family=Poiret+One|Open+Sans:400,700,600' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="stylesheet" type="text/css" href="style3.css">
		<script src="popup.js"></script>
		<title>Calendar</title>
	</head>
	<body>
		<div id="container">
			<div id="menu">
				<?php echo $previous_month_link;?>
				<h1><?php echo $title?></h1>
				<?php echo $next_month_link;?>
				<h2><?php echo $year?></h2>
				
				<?php 
				if (!isset($_SESSION['islogged']) ||$_SESSION['islogged'] !== true) {
					echo "<a class='login' href='login.php'>Login</a>";
					echo "<a class='signup' href='signup.php'>Sign Up</a>";
				} else {
					echo "<span class='hi'>Hi {$_SESSION['name']}!</span>";
					echo "<span id='message' class='added'></span>";
					echo "<a class='logout' href='logout.php'>Log Out</a>";
				}
				   
				?>
			</div>
			<div id="main">
				<?php
 
				echo "<table width=100%>";  
				echo "<tr class='weekTitle' height='40px'><td>Mon</td><td>Tue</td><td>Wed</td><td>Thu</td><td>Fri</td><td>Sat</td><td>Sun</td></tr>";    

				//Varmistaa että viikossa on 7 päivää
				$day_count = 1; 
				
				echo "<tr>"; 

				//Tyhjien päivien piirto
				while ( $blank > 0 )   
				{   
					echo "<td></td>";   
					$blank = $blank-1;   
					$day_count++;  
				}

				//Kuukauden ensimmäinen päivä 1 
				$day_num = 1; 
				  
				//Kunnes kaikki kuukauden päivät on tehty  
				while ( $day_num <= $days_in_month )   
				{   
			
					//Tapahtumien näyttö
					//Etunollien käsittely
					if(($month !== 10)&& ($month !== 11) && ($month !== 12)){
						if((10 > $day_num) && ($day_num > 0))
						{
							$event_date = $year . "-0" . $month . "-0". $day_num;
						}else{
							$event_date = $year . "-0" . $month . "-". $day_num;
						}
					}else{
						if((10 > $day_num) && ($day_num > 0))
						{
							$event_date = $year . "-" . $month . "-0". $day_num;
						}else{
							$event_date = $year . "-" . $month . "-". $day_num;
						}
					}
					$event="";
					$iduser = $_SESSION['userid'];
					$sql = "SELECT eventDate, header
							FROM event
							WHERE users_id = :user AND eventDate = :event";
					$stmt = $db->prepare($sql);
					$stmt->execute(array($iduser, $event_date));
					if ($stmt->rowCount() > 0){
						while($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
							$dbEventDate = $result["eventDate"];
							$dbEventTitle = $result["header"];
							$event .= "<input class='showEvent' id='$event_date' name='$event_date' type='submit' Value='$dbEventTitle' onclick='javascript:PopUpShow(this)'/>";
						}
					}
					
					//Tunnistaa tämän päivän ja asettaa eri tyyliasetukset
					if(date('d') == $day_num && date('m')== $month && date('Y') == $year) {
						if (!isset($_SESSION['islogged']) ||$_SESSION['islogged'] !== true) {
							echo "<td height='130px'><a href=# class='currentday'><strong> $day_num </strong></a></td>";
						}else{
							if($dbEventDate == $event_date){
								echo "<td height='130px'><a href='javascript:;' class='currentday' id='$event_date' onclick='PopUp(this)'><strong> $day_num </strong></a><br>$event</td>";
							}else{
								echo "<td height='130px'><a href='javascript:;'  class='currentday' id='$event_date' onclick='PopUp(this)' ><strong> $day_num </strong></a></td>";
							}
						}
						$day_num++;   
						$day_count++;   
					} else {
						if (!isset($_SESSION['islogged']) ||$_SESSION['islogged'] !== true) {
							echo "<td height='130px'><a href=#> $day_num </a></td>"; 
						}else{
							if($dbEventDate == $event_date){
								echo "<td height='130px'><a href='javascript:;' id='$event_date' onclick='PopUp(this)'> $day_num </a><br>$event</td>";
							}else{
								echo "<td height='130px'><a href='javascript:;' id='$event_date' onclick='PopUp(this)'> $day_num </a></td>";
							}
						}
						$day_num++;
						$day_count++;
				    }					
					//Varmistaa että uusi rivi aloitetaan joka viikkon jälkeen
					if ($day_count > 7)  {  
						echo "</tr>";
						$day_count = 1; 
						//Ei aloita uutta riviä lopussa ilman tarvetta
						if($day_count >1 && $day_count <=7){
							echo "<tr>";  
						} 
					}  
				}

				//Tyhjät ruudut loppuun jos tarvii
				while ( $day_count >1 && $day_count <=7 )  
				{	
					echo "<td></td>";   
					$day_count++;   
				} 
				
				if($day_count >1 && $day_count <=7){
					echo "</tr>";  
				}
				
				//Merkinnän lisäys/näyttö div
				include "addNote.php";
				include "showNote.php";
				include "editNote.php";
				?>
			</div>
		</div>
	</body>
</html>
