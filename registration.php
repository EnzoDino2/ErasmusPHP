<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Registration Form</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/superhero/bootstrap.min.css" integrity="sha384-HnTY+mLT0stQlOwD3wcAzSVAZbrBp141qwfR4WfTqVQKSgmcgzk+oP0ieIyrxiFO" crossorigin="anonymous">
<body>
	<div class="container">
	<?php
	include("registrationExt.php");
	?>

		<form action="registration.php" method="post">
		<br>
		<br>
			<div class="form-group">
				<label for="fullname">Full name:</label>
				<input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full name:" required>
			</div>
			<div class="form-group">
				<label for="email">Email:</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Email:" required>
			</div>
			<div class="form-group">
				<label for="password">Password:</label>
				<input type="password" class="form-control" id="password" name="password" placeholder="Password:" required>
			</div>
			<div class="form-group">
				<label for="repeat_password">Repeat Password:</label>
				<input type="password" class="form-control" id="repeat_password" name="repeat_password" placeholder="Repeat Password:" required>
			</div>
			<div class="form-group">
				<label for="school">Name of your school:</label>
				<input type="text" class="form-control" id="school" name="school" placeholder="Name of your school:" required>
			</div>
			<div class="form-btn">
				<input type="submit" class="btn btn-primary" name="submit" value="Register">
			</div>
			<br>
			<div><p>Already registered<a href="login.php">Login Here</a></p></div>
		</form>
	</div>
</body>
</html>