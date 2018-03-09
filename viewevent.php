<!DOCTYPE html>
<html>
<head>
	<title>View Event</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require 'header.php'; ?>
<?php
function eventToString() {
	require './database/epmtfafn_satta_db.php';
	$db = new Database();
	$db->openDatabase();
	$arr = $db->get_event_username($_SESSION['username']);
	$db->closeDatabase();
	$td = "";
	$count = 1;
	if (count($arr) == 0) {
		$td = "<label>Not found event.</label>";
	} else {
		foreach ($arr as $event) {
			$td .= "<tr>";
			$temp = "";
			$td .= "<td>".$count."</td>";
			foreach ($event as $key => $value) {
				switch ($key) {
					case 'name':
						$td .= "<td>".$value."</td>";
						break;
					case 'type':
						$td .= "<td>".$value."</td>";
						break;
				}
				if (!strcmp($key, "current")) {
					$temp = "<td>".$value;
				} else if (!strcmp($key, "capacity")) {
					$temp .= "/".$value."</td>";
					$td .= $temp;
				}

				if (!strcmp($key, "create_date_time")) {
					$temp = "<td>Create date: ".$value;
				} else if (!strcmp($key, "start_date_time")) {
					$temp .= "<br>Start date: ".$value;
				} else if (!strcmp($key, "end_date_time")) {
					$temp .= "<br>End date: ".$value;
					$td .= $temp;
				}
			}
			$count++;
			$td .= "</tr>";
		}
	}
	echo $td;
}
?>
<body>
	<div class="row content">
		<div class="col-sm-2" style="background-color:lavender;"></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12 text-center">
					<br>
					<h2>Event</h2>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<table class="table table-hover ">
					<thead class="table-danger">
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Type</th>
							<th>Capacity</th>
							<th>Create date</th>
						</tr>
					</thead>
					<tbody>
						<?php eventToString();?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-2" style="background-color:lavender;"></div>
	</div>
</body>
</html>