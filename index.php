<!doctype html>
<html>

<head>
	<title>axios - file upload example</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- bootstrap 5 files -->
	<link href="./css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<script src="./js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
	<script src="./js/jquery-3.6.0.min.js"></script>
	<script src="./js/axios.min.js"></script>
</head>

<body>
	<?php
	file_put_contents("count.txt", 0);
	session_start();
	$total_recs = isset($_SESSION['total_recs']) && $_SESSION['total_recs'] != null ? $_SESSION['total_recs'] : null;
	?>
	<div class="container" style="margin-top:50px">

		<form method="POST" action="save_file.php" enctype="multipart/form-data">
			<input type="file" id="file" name="file">
			<input type="submit" name="submit" onclick="getProgress()">
		</form>
		<div id="result"></div>
		<div class="progress">
			<div id="progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">
				<span class="sr-only"><span id="progress"></span>% Complete</span>
			</div>
		</div>
	</div>
</body>

<script>

function getProgress() {
	var source = new EventSource("get_progress.php");
	total_records = 0;

	source.onmessage = function(event) {
		total_records = JSON.parse(event.data)['total_records'];
		processed_records = JSON.parse(event.data)['count'];

		document.getElementById("result").innerHTML = "Records Processed: " + processed_records + "<br>";
		progress = (parseInt(processed_records) * 100) / total_records;
		
		$('#progress').html(progress);
		$('#progress-bar').attr('area-valuenow', progress);
		$('#progress-bar').attr('style', `width:${progress}%`);
		
	};
}
	
	if ("<?php echo isset($_GET['upload']) && $_GET['upload'] == 'true'; ?>") {
		progress = 100;
		$('#progress').html(progress);
		$('#progress-bar').attr('area-valuenow', progress);
		$('#progress-bar').attr('style', `width:${progress}%`);
		$('#progress-bar').removeClass('progress-bar-animated');
		document.getElementById("result").innerHTML = "All records processed successfully.<br>";
		// source.close();
	}
</script>

</html>