<!DOCTYPE html>
<html>
<head>
	<title>Comparing Source Code Of Different Two Pages</title>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<link href=
	"http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel=
	"stylesheet">
</head>
<body>
	<div class="container">
		<h1>Comparing</h1>
		<form action="../compare" enctype="multipart/form-data" method="post" role="form">

			<div class="form-group">
				<div class="radio">
					<label><input checked id="optionsRadios1" name="optionsRadios" type="radio" value="option1">
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
					<label><input id="optionsRadios2" name="optionsRadios" type="radio" value="option2">
						<strong>Upload File (csv or html file.)</strong>
					</label><input accept=".csv, .html" id="fileInput" name="fileInput" type="file">
				</div>
			</div>

			<div class="form_group">
				<button class="btn btn-default" name="submit" type="submit">Submit</button>
			</div>

		</form>
	</div>
</body>
</html>