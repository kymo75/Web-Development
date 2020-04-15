<?php

require('connect.php');
session_start();

//	Retrieve all comments where there is no reply
$query = "SELECT * FROM comments WHERE parent_comment_id = '0' ORDER BY comment_id DESC";

$statement = $db->prepare($query);
$statement->execute();

$result = $statement->fetchAll();

$output = '';
foreach($result as $row){
	if (!empty($row['username'])){
		$output .= '
		<div class="panel panel-default" style="padding:20px;">
			<div class="panel-heading">By <b>'.$row["username"].'</b> on <i>'.$row["date"].'</i></div>
			<div class="panel-body">'.$row["comment"].'</div>
  			<div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
		</div>
		';
	}
	else{
		$output .= '
 		<div class="panel panel-default" style="padding:20px;">
  			<div class="panel-heading">By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
  			<div class="panel-body">'.$row["comment"].'</div>
  			<div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
 		</div>
 		';
	}

$output .= get_reply_comment($db, $row["comment_id"]);
}

echo $output;

//	gets the reply comments where it has an existing parent comment_id
function get_reply_comment($db, $parent_id = 0, $marginleft = 0){
	$query = "SELECT * FROM comments WHERE parent_comment_id = '".$parent_id."'";
	$output = '';

	$statement = $db->prepare($query);
	$statement->execute();

	$result = $statement->fetchAll();
	$count = $statement->rowCount();

	if($parent_id == 0){
		$marginleft = 0;
	}
	else{
		$marginleft = $marginleft + 48;
	}

	//	A reply exists!
	if ($count > 0){
		foreach($result as $row){
			if (!empty($row['username'])){
				$output .='
				<div class="panel panel-default" style="margin-left:'.$marginleft.'px">
					<div class="panel-heading"> By <b>'.$row["username"].'</b> on <i>'.$row["date"].'</i></div>
					<div class="panel-body">'.$row["comment"].'</div>
					<div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
				</div>
				';
			}
			else{
				$output .= '
				<div class="panel panel-default" style="margin-left:'.$marginleft.'px">
					<div class="panel-heading"> By <b>'.$row["comment_sender_name"].'</b> on <i>'.$row["date"].'</i></div>
					<div class="panel-body">'.$row["comment"].'</div>
					<div class="panel-footer" align="right"><button type="button" class="btn btn-default reply" id="'.$row["comment_id"].'">Reply</button></div>
				</div>
				';
			}

		$output .= get_reply_comment($db, $row["comment_id"], $marginleft);
		}
	}
	return $output;
}

?>