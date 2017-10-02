<!DOCTYPE html>
<html lang="en">
<head>

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  </head>
  <body>
<!-- Global Site Tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-107387074-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments)};
  gtag('js', new Date());

  gtag('config', 'UA-107387074-1');
</script>
  <div class="jumbotron">
	<h1> CHUNK Machine! </h1>
  </div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="form-group">
					<label for="exampleTextarea"><strong>Dump your list below</strong></label>
					<input type="text" id="idFilter" placeholder="Filter By ..." class="pull-right">
					<textarea class="form-control" id="idList" rows="3"></textarea>
				  </div>
			<div>
		</div> <!-- row -->
		<div class="row">
			<div class="col-md-12">
				<button id="btnRandom" type="button" class="btn btn-primary">Random</button>
				<button id="btnSerial" type="button" class="btn btn-info">Serial</button>
				<button id="btnReset" type="button" class="btn btn-danger">Reset</button>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12" style="margin-top:60px">
				<div class="alert alert-info" role="alert" id="idDisplay">
					  <strong>Press Button Above</strong>
				</div>	
			</div>	
		</div>

	</div> <!-- container -->
    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>

	<script>
		var lineArray = [];
		var numberOfGoodLines = 0;
		var currentIndex = 0;
		var clickMode = '';

		function isLineGood(line)
		{
			var re = /\w/;
			var match = re.exec(line);
			if (match === null) {
				return false;
			}

			var filter = $('#idFilter').val();
			if (!filter) {
				return true;
				
			}
			re = new RegExp(filter);
			match = re.exec(line);
			if (match === null) {
				return false;
			}
			return true;
		}

		function listChanged()
		{
			lineArray = [];
			numberOfGoodLines = 0;
			currentIndex = 0;
			// go ahead and break the items line wise
			tempLineArray = $('#idList').val().split("\n");

			var size = tempLineArray.length;
			for (i = 0; i < size; i++) {
				var item = tempLineArray[i];
				if (!isLineGood(item)) {
					continue;
				}
				numberOfGoodLines++;

				var originalLineNumber = i + 1;
				lineArray.push(originalLineNumber + ') ' + item);
			}
		}

		function buttonRandomClicked()
		{
			if (clickMode != 'R') {
				listChanged();
			}
			clickMode = 'R';

			var size = lineArray.length;
			if (size == 0) {
				if (numberOfGoodLines == 0) {
					return;
				}

				// it means we need to refill the array
				listChanged();
				size = lineArray.length;
			}

			var r = (2 * Math.random() * size) % size;
			r = parseInt(r);

			currentIndex = r; 

			$('#idDisplay').html(lineArray[r]);

			lineArray.splice(r, 1);
		}

		function buttonSerialClicked()
		{
			if (clickMode != 'S') {
				// if the previous click was not in serial
				listChanged();
				currentIndex = 0;
			}
			clickMode = 'S'; // random

			$('#idDisplay').html(lineArray[currentIndex]);
			currentIndex++;

			if (currentIndex == lineArray.length) {
				currentIndex = 0;
			}
		}

		function buttonResetClicked()
		{
			$('#idList').val('');
			lineArray = [];
			numberOfGoodLines = 0;
			currentIndex = 0;
			clickMode = '';
			$('#idDisplay').html("<strong>Lets start again ...</strong>");
		}

		$(document).ready(function() {
			$('#idList').on('change', listChanged);
			$('#btnRandom').on('click', buttonRandomClicked);
			$('#btnSerial').on('click', buttonSerialClicked);
			$('#btnReset').on('click', buttonResetClicked);
		}); 
	</script>

  </body>
</html>
