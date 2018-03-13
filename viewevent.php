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
require './database/epmtfafn_satta_db.php';

$is_show_next = "";
$is_show_previous = "";
$is_show_btn_filter = "noshow";
$next_page = 0;
$previous_page = 0;
$str_table = "";
$hasFilter = false;
$is_show_export = "noshow";
if (isset($_POST['status'])) {
	if ($_POST['status'] == "delete-event") {
		$db = new Database();
		$db->openDatabase();
		$db->update_event_finish($_POST['noevent']);
		$db->closeDatabase();
		$_POST['status'] = "";
	} else if ($_POST['status'] == "cancel-event") {
		$db = new Database();
		$db->openDatabase();
		$db->decline_eventmember($_POST['noevent'], $_SESSION['username']);
		$db->closeDatabase();
		$_POST['status'] = "";
	} else if ($_POST['status'] == "filter") {
		$db = new Database();
		$db->openDatabase();
		$e = $db->get_event_and_seminar_all();
		$filter = array();
		$c = 0;
		for ($i=0; $i<count($e); $i++) {
			$date = $e[$i]['create_date_time'];
			$date = new DateTime($date);
			$date = $date->format("Y-m-d");
			$location = $e[$i]['location'];
			$current = $e[$i]['current'];
			$nickname = $db->infoUsername($e[$i]['username'])['nickname'];
			$fdate = $_POST['date'];
			$organizer = $_POST['organizer'];
			$flocation = $_POST['location'];
			$fcurrent = $_POST['current'];
			// print_r("date: ".$date." fdate: ".$fdate."<br>".strpos($date,$fdate));
			// print_r("location: ".$location." flocation: ".$flocation."<br>");
			// print_r("nickname: ".$nickname." organizer: ".$organizer);

			if ($date == $fdate || $nickname == $organizer || strpos($location, $flocation) !== false || $current == $fcurrent) {
				$filter[$c] = $e[$i];
				$c++;
				$is_show_export = "";
			}
			$hasFilter = true;
		}
		$db->closeDatabase();
	}
}

function pageToString($number, $arr) {
	$capacity = 5;
	$begin = 1;
	$max = ($number*$capacity);
	if ($number > 1) {
		$begin = (($number-1)*$capacity)+1;
	}

	if ((count($arr) - $begin) < $capacity) {
		$GLOBALS['is_show_next'] = "noshow";
	} else {
		$GLOBALS['next_page'] = $number+1;
	}
	if ($number == 1) {
		$GLOBALS['is_show_previous'] = "noshow";
	} else {
		$GLOBALS['previous_page'] = $number-1;
	}

	$str = '';
	for ($i=$begin; $i <= $max && $i <= count($arr); $i++) {
		$event = $arr[$i-1];
		if ($event['status'] == 1) {
			continue;
		}
		$td = "<tr>";
		$temp = "";
		$td .= "<td>".$i."</td>";
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
				$temp .= "<br>End date: ".$value."</td>";
				$td .= $temp;
			}
		}
		if ($_SESSION['position'] == "admin") {
			$td .= '<td><form method="POST" onsubmit="return confirm(\'Do you want delete event `'.$event['name'].'` from website?\')"><input type="hidden" name="status" value="delete-event"><input type="hidden" name="noevent" value="'.$event['noevent'].'"><button type="submit" class="btn btn-primary" name="submit">Delete</button></form></td></tr>';
		} else {
			if ($event['username'] == $_SESSION['username']) {
				$td .= '<td><form method="POST" onsubmit="return confirm(\'Do you want end event `'.$event['name'].'`?\')"><input type="hidden" name="status" value="delete-event"><input type="hidden" name="noevent" value="'.$event['noevent'].'"><button type="submit" class="btn btn-primary" name="submit">End</button></form></td></tr>';
			} else {
				$td .= '<td><form method="POST" onsubmit="return confirm(\'Do you want cancel event `'.$event['name'].'`?\')"><input type="hidden" name="status" value="cancel-event"><input type="hidden" name="noevent" value="'.$event['noevent'].'"><button type="submit" class="btn btn-primary" name="submit">Cancel</button></form></td></tr>';
			}
		}
		$str .= $td;
	}
	return $str;
}

$arr = array();
$db = new Database();
$db->openDatabase();

if ($_SESSION['position'] == "admin") {
	$is_show_btn_filter = "";
}

if ($hasFilter) {
	$arr = $filter;
} else if ($_SESSION['position'] == "admin") {
	$arr = $db->get_event_and_seminar_all();
} else {
	$arr = $db->get_event_username($_SESSION['username']);
}

$db->closeDatabase();
if (isset($_POST['next_page']) && count($arr) > 0) {
	$str_table = pageToString($_POST['next_page'], $arr);
} else {
	$str_table = pageToString(1, $arr);
}
?>
<body>
	<div class="row content">
<div id="event-filter-myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
					<!-- <h4 class="text-center" id="login-header">Filter</h4> -->
	        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span></button>
	      </div>
	      <div class="modal-body clearfix ml-4 mr-4" id="event-filter-content">
	      	<form method="POST">
  					<div class="form-group">
		      		<label id="">Create event date</label>
		      		<input type="date" class="form-control" name="date" required>
		      		<span class="help-block">This field is require.</span>
   					</div>
	      		<div class="form-group">
	      			<label id="text-avatar">Organizer Nickname</label>
		      		<input type="text" class="form-control" name="organizer" valu="">
		      		<span class="help-block">Blank if you don't want to filter it.</span>
	      		</div>
	      		<div class="form-group">
	      			<label id="text-avatar">Location</label>
		      		<input type="text" class="form-control" name="location" value="">
		      		<span class="help-block">Blank if you don't want to filter it.</span>
	      		</div>
	      		<div class="form-group">
	      			<label id="text-avatar">Current Member</label>
		      		<input type="text" class="form-control" name="current" value="">
		      		<span class="help-block">Blank if you don't want to filter it.</span>
	      		</div>
	      		<input type="hidden" name="status" value="filter">
	      		<button type="submit" class="btn btn-primary">Filter</button>
	      	</form>
	      </div>
	    </div>
	  </div>
	</div>
		<div class="col-sm-2" ></div>
		<div class="col-sm-8">
			<div class="row">
				<div class="col-sm-12 ">
					<br>
					<h1>View event</h1>
				  <hr style="height:5px;  background-color:#FF6666	;">
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<button type="button" id="btn-filter" class="btn btn-info btn-lg noshow <?php echo $is_show_btn_filter; ?>" data-toggle="modal" data-target="#event-filter-myModal">Filter</button>
					<form method="POST" action="./admin-export.php">
						<input type="hidden" name="event" value="<?php echo htmlspecialchars(json_encode($arr)); ?>">
						<button type="submit" class="btn btn-success name="submit" <?php echo $is_show_export; ?>">Export</button>
					</form>

				</div>
				<div class="col-sm-2"></div>
			</div>
			<div class="row">
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="viewevent-previous-page-form" method="POST" >
						<input type="hidden" name="next_page" value="<?php echo $previous_page;?>">
						<a class="btn btn-primary btn-sm float-right <?php echo $is_show_previous;?>" onclick="document.getElementById('viewevent-previous-page-form').submit();">Previous</a>
					</form>
				</div>
				<div class="col-sm-8">
					<table class="table table-hover table-sm">
						<thead class="table-danger">
							<tr>
								<th>#</th>
								<th>Name</th>
								<th>Type</th>
								<th>Capacity</th>
								<th>Create date</th>
								<td>Action</td>
							</tr>
						</thead>
						<tbody>
							<?php echo $str_table; ?>
						</tbody>
					</table>
				</div>
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="viewevent-next-page-form" method="POST">
						<input type="hidden" name="next_page" value="<?php echo $next_page;?>">
						<a class="btn btn-primary btn-sm <?php echo $is_show_next;?>" onclick="document.getElementById('viewevent-next-page-form').submit();">Next</a>
					</form>
				</div>
			</div>
		</div>
		<div class="col-sm-2" ></div>
	</div>
</body>
</html>
