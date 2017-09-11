<?php 
include_once("db_connect.php");
?>

<!DOCTYPE html>
<html>
<head>
		<title>Check List</title>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<script type="text/javascript" charset="utf8" src="http://code.jquery.com/jquery-1.10.2.js"></script>
	<link rel="stylesheet" id="font-awesome-style-css" href="http://phpzag.com/demo/bootstrap/css/bootstrap.min.css" type="text/css" media="all">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
			
	<link href="style.css" rel="stylesheet">
	<link rel="stylesheet" href="jquery-ui.css">
	<script src="jquery-3.2.1.js"></script>
	<script src="jquery-ui.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet">


	<script>
		$(document).ready(function(){
		$("input[type=checkbox]").removeAttr("checked");
		$("#todolist").sortable({axis:"y", containment:"#projects", 	
		update: function( event, ui ) {
			updateDisplayOrder();
		}
	});
		$("#projects").on("click", "input[type=checkbox]", function(){
			$(this).closest("li").animate(function(){
				$(this).checked()
			});
		});
		$("#projects").on("click", ".ui-icon-trash", function(){
			$(this).closest("li").slideUp(function(){
				var checklist_id = $(this).attr('checklist_id');
					$.ajax({
			        type: "GET",
			        url: "remove.php",
			        data:  dataString,
			        success:function(){
			             $(this).remove();
			             alert("Data deleted");

			       }
			  })
				$(this).remove();
			 
			});
		});
		$("#btnAddTask").button()
		.click(function(){
			$("#task-dialog").dialog({width:400, resizable:false, modal:true,dialogClass: 'no-close success-dialog', opacity:0.5, buttons:{
				"Add":function(newtask){
						$("#todolist").append("<li><input type='checkbox'>&nbsp;&nbsp;" + $("#new-task").val() + "<span class='ui-icon ui-icon-trash'></span></li>");
						$("#new-task").val("");
						$(this).dialog("close");
						}, 
				"Cancel":function(){
						$("#new-task").val("");
						$(this).dialog("close");
						}
					}});
				 });
		
		
		});

jQuery.ajax({
    type: "post",
    url: 'newtask.php',
    dataType: 'json',
    data: {functionname: 'newtask'},

    success: function (obj, textstatus) {
                  if( !('error' in obj) ) {
                      yourVariable = obj.result;
                  }
                  else {
                      console.log(obj.error);
                  }
            }
});


// function to save display sort order  
function updateDisplayOrder() {
	var selectedLanguage = new Array();
	$('ol#todolist li').each(function() {
	selectedLanguage.push($(this).attr("checklist_id"));
	});
	var dataString = 'sort_order='+selectedLanguage;
	$.ajax({
	type: "GET",
	url: "update_order.php",
	data: dataString,
	cache: false,
	success: function(data){
}
});
}	

	</script>


</head>
<body>
<div id="container">
		<h2>Wedding Check List</h2>
		<div id="projects">
			<ol id="todolist">

		<?php
	$sql = "SELECT checklist_id, thingstodo FROM checklist ORDER BY display_order";
	$resultset = mysqli_query($conn, $sql) or die("database error:". mysqli_error($conn));
	while( $rows = mysqli_fetch_assoc($resultset) ) { 
	?>	
	<li id="list" checklist_id=<?php echo $rows["checklist_id"]; ?>>
	<input type="checkbox">
	&nbsp;&nbsp;<?php echo $rows["thingstodo"]; ?>
	<span class="ui-icon ui-icon-trash"></span></li>
	<?php }	?>	
	</ul>
		
	
			</ol>
		</div>
		<input type="image" id="btnAddTask" src="images/addicon.png" width="52" height="52"  style="background-color: white" ></input>
		
		<div id="task-dialog" title="Add a task" style="display:none;">
			<label for="new-task"></label><input id="new-task" type="text" />
		</div>
		
</div>


</body>
</html>