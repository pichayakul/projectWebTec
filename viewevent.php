<!DOCTYPE html>
<html>
<head>
	<title>View Event</title>
	<meta charset="utf-8">
</head>
<? require 'header.php'; ?>
<?
function eventToString() {
	require './database/epmtfafn_satta_db.php';
	$db = new Database();
	$db->openDatabase();
	$db->closeDatabase();
	echo "eventToString";
}
?>
<body>
	<div class="row content">
		<div class="col-sm-1" style="background-color:lavender;"></div>
		<div class="col-sm-10">
			<div class="row">
				<div class="col-sm-12 text-center">
					<br>
					<h2>Event</h2>
					<hr>
					<br>
				</div>
			</div>
			<div class="row">
				<table class="table">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Capacity</th>
							<th>Create date</th>
						</tr>
					</thead>
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-sm-1" style="background-color:lavender;"></div>
	</div>
</body>
</html>