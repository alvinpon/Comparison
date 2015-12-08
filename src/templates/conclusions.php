<!DOCTYPE html>
<html>
	<head>
		<title>Conclusions</title>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<h2>Conclusions</h2>
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
						<?php for ($i = 0; $i < count($arrayOfConclusion); $i++) : ?>
						<tr>
							<td><?php echo $i + 1;			?></td>
							<td><?php echo $arrayOfFirstURL[$i];	?></td>
							<td><?php echo $arrayOfSecondURL[$i];	?></td>
							<td><?php echo $arrayOfConclusion[$i];	?></td>
						</tr>
						<?php endfor ?>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>