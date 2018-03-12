<!DOCTYPE html>
<html>
<head>
	<title>Log</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
</head>
<?php require './header.php'; ?>
<?php
	$is_show_next = "";
	$is_show_previous = "";
	$next_page = 0;
	$previous_page = 0;
	$str_table = "";
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

		$str = '<table class="table table-bordered table-striped table-sm"><thead><th>#</th><th>Username</th><th>Date time</th><th class="w-50">Action</th></thead><tbody>';
		for ($i=$begin; $i <= $max && $i <= count($arr); $i++) {
			$username = $arr[$i-1]['username'];
			$date_time = $arr[$i-1]['date_time'];
			$action = $arr[$i-1]['action'];
			$str .= '<tr>';
			$str .= '<td>'.$i.'</td>';
			$str .= '<td>'.$username.'</td>';
			$str .= '<td>'.$date_time.'</td>';
			$str .= '<td>'.$action.'</td>';
			$str .= '</tr>';
		}
		$str .= "</tbody></table>";
		return $str;
	}

	require './database/epmtfafn_satta_db.php';
	$db = new Database();
	$db->openDatabase();
	$arr = $db->get_userLog_all();

	if (isset($_POST['next_page'])) {
		$str_table = pageToString($_POST['next_page'], $arr);
	} else {
		$str_table = pageToString(1, $arr);
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
					<a class="btn btn-primary btn-sm float-left" href="./management.php">< Back</a>
					<br>
					<hr>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2>Log</h2>
					<br>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="previous-page-form" method="POST" >
						<input type="hidden" name="next_page" value="<?php echo $previous_page;?>">
						<a class="btn btn-primary btn-sm float-right <?php echo $is_show_previous;?>" onclick="document.getElementById('previous-page-form').submit();">Previous</a>
					</form>
				</div>
				<div class="col-sm-8">
					<h5>All log (5 action per page)</h5>
					<?php  echo $str_table;?>
				</div>
				<div class="col-sm-2 h-25 mt-auto mb-auto">
					<form id="next-page-form" method="POST">
						<input type="hidden" name="next_page" value="<?php echo $next_page;?>">
						<a class="btn btn-primary btn-sm <?php echo $is_show_next;?>" onclick="document.getElementById('next-page-form').submit();">Next</a>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 clearfix">
					<br>
					<br>
					<hr>
				</div>
			</div>
		</div>
		<div class="col-sm-2" style="background-color:lavender;"></div>
	</div>
</body>
</html>