function PopUp(theID){
	var day = (theID.id);
	document.getElementById('light').style.display='block';
	document.getElementById('fade').style.display='block';
	document.getElementById('addNoteDate').value = day;
}

function PopUpShow(theID){
	var day = (theID.id);
	document.getElementById('show').style.display='block';
	document.getElementById('fade').style.display='block';
	var hr = new XMLHttpRequest();
	var url = "showNote.php";
	var vars = "day="+day;
	hr.open("POST",url,true);
	hr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var return_data = hr.responseText;
			document.getElementById('events').innerHTML = return_data;
		}
	}
	hr.send(vars);
}

function Close(){
	document.getElementById('show').style.display='none';
	document.getElementById('light').style.display='none';
	document.getElementById('editEvent').style.display='none';
	document.getElementById('fade').style.display='none';
}

function Delete(id){
	var id = (id.id);
	var hr = new XMLHttpRequest();
	var url = "delete.php";
	var vars = "id="+id;
	hr.open("POST",url,true);
	hr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var return_data = hr.responseText;
			location.reload();
			document.getElementById('message').innerHTML = return_data;
		}
	}
	hr.send(vars);
	Close();
}

function Edit(id){
	var id = (id.id);
	document.getElementById('editEvent').style.display='block';
	document.getElementById('fade').style.display='block';
	var hr = new XMLHttpRequest();
	var url = "edit.php";
	var vars = "id="+id;
	hr.open("POST",url,true);
	hr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	hr.onreadystatechange = function(){
		if(hr.readyState == 4 && hr.status == 200){
			var return_data = hr.responseText;
			document.getElementById('data').innerHTML = return_data;
		}
	}
	hr.send(vars);
}