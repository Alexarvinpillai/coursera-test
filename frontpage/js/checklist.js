$(function(){
	$(document).ready(function(){
		$("input[type=checkbox]").removeAttr("checked");
		$("#todolist").sortable({axis:"y", containment:"#projects"});
		$("#projects").on("click", "input[type=checkbox]", function(){
			$(this).closest("li").animate(function(){
				$(this).checked()
			});
		});
		$("#projects").on("click", ".ui-icon-trash", function(){
			$(this).closest("li").slideUp(function(){
				$(this).remove();
			});
		});
		$("#btnAddTask").button()
		.click(function(){
			$("#task-dialog").dialog({width:400, resizable:false, modal:true,dialogClass: 'no-close success-dialog', opacity:0.5, buttons:{
				"Add":function(){
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
	 });