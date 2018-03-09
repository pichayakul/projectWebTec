<!DOCTYPE html>
<html>
<head>
	<title>Management</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require './header.php';?>
<?php
	require './database/epmtfafn_satta_db.php';
	$db = new Database();
	$db->openDatabase();
	$account = $db->get_account_all();
	$total_account = count($account);
	$active_account = 0;
	$ban_account = 0;
	foreach ($account as $user) {
		foreach ($user as $key => $value) {
			if(!strcmp($key, "status_ban")) {
				if ($value == 0) {
					$active_account++;
				} else {
					$ban_account++;
				}
			}
		}
	}
	$events = $db->get_event_and_seminar_all();
	$total_event = count($events);
	$event = 0;
	$seminar = 0;
	$fevent = 0;
	$fseminar = 0;
	foreach ($events as $arr) {
		if ($arr['type'] == "event") {
			$event++;
			if ($arr['status'] == 1) {
				$fevent++;
			}
		} else {
			$seminar++;
			if ($arr['status'] == 1) {
				$fseminar++;
			}
		}
	}
	$db->closeDatabase(); 
?>
<body>
	<div class="row content">
		<div class="col-sm-2" style="background-color:lavender;"></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12 clearfix">
					<br>
					<a class="btn btn-primary btn-sm float-right" href="./manageuser.php">Management User</a>
					<a class="btn btn-primary btn-sm float-right" href="./viewlog.php">Log</a>
					<a class="btn btn-primary btn-sm float-right" href="./eventreport.php">Report</a>
					<br>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2>Website Detail</h2>
					<br>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<h4>website</h4>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td class="w-25">Website name</td>
							<td>Satta Garden</td>
						</tr>
						<tr>
							<td>About</td>
							<td>Management event and seminar.</td>
						</tr>
						<tr>
							<td>Contact</td>
							<td>suphawich.s@ku.th</td>
						</tr>
					</tbody>
				</table>
				<h4>User</h4>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td class="w-25">Total account</td>
							<td><?php echo $total_account;?> users</td>
						</tr>
						<tr>
							<td>Active account</td>
							<td><?php echo $active_account;?> users</td>
						</tr>
						<tr>
							<td>Banned account</td>
							<td><?php echo $ban_account;?> users</td>
						</tr>
					</tbody>
				</table>
				<h4>Event & Seminar</h4>
				<table class="table table-bordered table-striped">
					<tbody>
						<tr>
							<td class="w-25">Total room</td>
							<td><?php echo $total_event;?> rooms</td>
						</tr>
						<tr>
							<td>Total Event</td>
							<td><?php echo $event;?> rooms</td>
						</tr>
						<tr>
							<td>Total Seminar</td>
							<td><?php echo $seminar;?> rooms</td>
						</tr>
						<tr>
							<td>Finished event</td>
							<td><?php echo $fevent;?> rooms</td>
						</tr>
						<tr>
							<td>Finished seminar</td>
							<td><?php echo $fseminar;?> rooms</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-2" style="background-color:lavender;"></div>
	</div>
</body>
</html>