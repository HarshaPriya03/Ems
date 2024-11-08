<!DOCTYPE html>
<html lang="en">
<head>
	<title>Ajax File Upload</title>
	<meta charset="utf-8">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script>
		$(document).ready(function(e){
			$("#fupForm").on('submit', function(e){
				e.preventDefault();
				$.ajax({
					type: 'POST',
					url: 'upload.php',
					data: new FormData(this),
					contentType: false,
					cache: false,
					processData:false,
					beforeSend: function(){
						$('.submitBtn').attr("disabled","disabled");
						$('#fupForm').css("opacity",".5");
					},
					success: function(msg){ console.log(msg);
						$('.statusMsg').html('');
						if(msg == 'ok'){
							$('#fupForm')[0].reset();
							$('.statusMsg').html('<span style="font-size:18px;color:#34A853">Form data submitted successfully.</span>');
						}else{
							$('.statusMsg').html('<span style="font-size:18px;color:#EA4335">Some problem occurred, please try again.</span>');
						}
						$('#fupForm').css("opacity","");
						$(".submitBtn").removeAttr("disabled");
					}
				});
			});
		
			//file type validation
			$("#file").change(function() {
				var file = this.files[0];
				var imagefile = file.type;
				var match= ["application/pdf"];
				if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
					alert('Please select a valid pdf file .');
					$("#file").val('');
					return false;
				}
			});
		});
	</script>
</head>
<body>

	<div class="container mt-3">
		<h2>Ajax File Upload with Form Data</h2>
		<p class="statusMsg"></p>
		<form enctype="multipart/form-data" id="fupForm" >
			<div class="form-group">
				<label for="name">NAME</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter name" required />
			</div>
			<div class="form-group">
			<label for="email">EMAIL</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required />
			</div>
			<div class="form-group">
				<label for="file">File</label>
				<input type="file" class="form-control" id="file" name="file" required />
			</div>
			<br>
			<input type="submit" name="submit" class="btn btn-danger submitBtn" value="SAVE"/>
		</form>
	</div>

</body>
</html>