<!DOCTYPE html>
<html>
<head>
	<title>Result</title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<h2>Result</h2>
		<div class="table-responsive">          
			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>First URL</th>
						<th>Second URL</th>
						<th>Conclusion</th>
					</tr>
				</thead>
				<tbody>
					<?php for ($i = 0; $i < count($conclusion); $i++) : ?>
						<tr>
							<td><?php echo $i + 1;			?></td>
							<td><?php echo $firstURL[$i];	?></td>
							<td><?php echo $secondURL[$i];	?></td>
							<td><?php echo $conclusion[$i];	?></td>
						</tr>
					<?php endfor ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>