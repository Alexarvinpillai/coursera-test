<?php
$functionName = $_REQUEST['action'];
$title = $_REQUEST['title'];
$connection = mysql_connect("localhost", "root", "") or die("Problem with connection!!");
mysql_select_db("mysite");
if($functionName == "getProjects")
{
 $output1 = array();
 $projects = mysql_query("SELECT projectId, title FROM projects");
 while($row = mysql_fetch_array($projects)){
 $output1[$row['projectId']] = $row['title'];
 }
 echo json_encode($output1);
}
if($functionName == "getTasks")
{
 $output2 = array();
 $tasks = mysql_query("SELECT projects.projectId, projects.title, tasks.title FROM projects INNER JOIN tasks ON projects.projectId = tasks.projectId");
 while($row = mysql_fetch_array($tasks)){
 $output2[$row[2]] = $row[0];
 }
 echo json_encode($output2);
}
if($functionName == "deleteTasks")
{
 if($title != "")
 {
 $sql = 'DELETE FROM tasks WHERE title="' . $title . '"';
 echo $sql;
 $ret = mysql_query($sql, $connection);
 }
 echo $ret;
}
?>