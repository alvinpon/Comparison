<!DOCTYPE html>
<html>
	<head>
		<title>Comparing Content Of Different Two Pages</title>
		<meta charset="utf-8">
		<meta content="width=device-width, initial-scale=1" name="viewport">
		<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
		<script src="js/default.js"></script>
	</head>
	<body onload="loadPage()">
		<div class="container">
			<h1>Comparing</h1>
			<form action="../compare" enctype="multipart/form-data" method="post" role="form">
				<div class="form-group">
					<div class="radio">
						<label>
							<input id="optionsRadios1" name="optionsRadios" onclick="clickURL()" type="radio" value="option1" checked>
							<strong>Enter URLs</strong>
						</label>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<div class="input-group">
								<div class="input-group-addon">URL1</div>
								<input class="form-control" id="URL1" name="URL1" placeholder="Enter URL1" type="url">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="input-group">
								<div class="input-group-addon">URL2</div>
								<input class="form-control" id="URL2" name="URL2" placeholder="Enter URL2" type="url">
							</div>
						</div>
					</div>
				</div>
				<div class="form_group">
					<div class="radio">
						<label>
							<input id="optionsRadios2" name="optionsRadios" onclick="clickFile()" type="radio" value="option2">
							<strong>Upload File (.csv or .html file.)</strong>
						</label>
					</div>
					<input accept=".csv, .html" id="fileInput" name="fileInput" type="file">
				</div>
				
				<button class="btn btn-default" type="submit">Submit</button>
			</form>
		</div>
	</body>
</html>