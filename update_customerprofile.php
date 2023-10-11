<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>UPDATE CUSTOMER</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

        <div class="container-fluid">
			<div class="standard-container bg-white shadow">
				<h1 class="h3 mb-3 fw-normal">Update Customer Profile: <?php echo($_SESSION['username']); ?></h1>
				<form class="row g-3" action="process4.php" method="POST">
				
				<div class="col-md-3">
						<label for="inputPIN" class="form-label">PIN</label>
						<input required type="password" name="pin" class="form-control" id="inputPIN">
					</div>
					<div class="col-md-3">
						<label for="inputPIN2" class="form-label">Re-Enter PIN</label>
						<input required type="password" class="form-control" id="inputPIN2">
					</div>
					<div class="col-md-6">
						<label for="inputFirstname" class="form-label">First Name</label>
						<input required type="text" name="fname" class="form-control" id="inputFirstname">
					</div>
					<div class="col-md-6">
						<label for="inputLastname" class="form-label">Last Name</label>
						<input required type="text" name="lname" class="form-control" id="inputLastname">
					</div>
					<div class="col-12">
						<label for="inputAddress" class="form-label">Address</label>
						<input required type="text" name="address" class="form-control" id="inputAddress" placeholder="1234 Main St">
					</div>
					<div class="col-md-6">
						<label for="inputCity" class="form-label">City</label>
						<input required type="text" name="city" class="form-control" id="inputCity">
					</div>
					<div class="col-md-4">
						<label for="inputState" class="form-label">State</label>
						<select id="inputState" name="state" class="form-select">
							<option selected disabled>Choose...</option>
							<option value="AL">Alabama</option>
							<option value="AK">Alaska</option>
							<option value="AZ">Arizona</option>
							<option value="AR">Arkansas</option>
							<option value="CA">California</option>
							<option value="CO">Colorado</option>
							<option value="CT">Connecticut</option>
							<option value="DE">Delaware</option>
							<option value="DC">District of Columbia</option>
							<option value="FL">Florida</option>
							<option value="GA">Georgia</option>
							<option value="GU">Guam</option>
							<option value="HI">Hawaii</option>
							<option value="ID">Idaho</option>
							<option value="IL">Illinois</option>
							<option value="IN">Indiana</option>
							<option value="IA">Iowa</option>
							<option value="KS">Kansas</option>
							<option value="KY">Kentucky</option>
							<option value="LA">Louisiana</option>
							<option value="ME">Maine</option>
							<option value="MD">Maryland</option>
							<option value="MA">Massachusetts</option>
							<option value="MI">Michigan</option>
							<option value="MN">Minnesota</option>
							<option value="MS">Mississippi</option>
							<option value="MO">Missouri</option>
							<option value="MT">Montana</option>
							<option value="NE">Nebraska</option>
							<option value="NV">Nevada</option>
							<option value="NH">New Hampshire</option>
							<option value="NJ">New Jersey</option>
							<option value="NM">New Mexico</option>
							<option value="NY">New York</option>
							<option value="NC">North Carolina</option>
							<option value="ND">North Dakota</option>
							<option value="OH">Ohio</option>
							<option value="OK">Oklahoma</option>
							<option value="OR">Oregon</option>
							<option value="PA">Pennsylvania</option>
							<option value="PR">Puerto Rico</option>
							<option value="RI">Rhode Island</option>
							<option value="SC">South Carolina</option>
							<option value="SD">South Dakota</option>
							<option value="TN">Tennessee</option>
							<option value="TX">Texas</option>
							<option value="UT">Utah</option>
							<option value="VT">Vermont</option>
							<option value="VA">Virginia</option>
							<option value="WA">Washington</option>
							<option value="WV">West Virginia</option>
							<option value="WI">Wisconsin</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>
					<div class="col-md-2">
						<label for="inputZip" class="form-label">Zip</label>
						<input type="text" name="zip" class="form-control" id="inputZip">
					</div>
					<div class="col-md-3">
						<label for="inputCardType" class="form-label">Card Provider</label>
						<select id="inputCardType" name="cardProvider" class="form-select">
							<option selected disabled>Choose...</option>
							<option value="Discover">Discover</option>
							<option value="MasterCard">MasterCard</option>
							<option value="Visa">Visa</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="inputCardNum" class="form-label">Credit Card Number</label>
						<input name="cardNum" class="form-control" id="inputCardNum">
					</div>
					<div class="col-md-3">
						<label for="inputExpDate" class="form-label">Exp. Date</label>
						<input required type="text" name="ccExp" class="form-control" id="inputExpDate" placeholder="MM/YY">
					</div>
					<div class="col-6 text-end">
						<a class="btn btn-md btn-warning" href="index.php">Cancel</a>
					</div>
					<div class="col-6 text-start">
						<button type="submit" name="submit" class="btn btn-primary">Update</button>
					</div>
				</form>
			</div>
		</div>


		<?php include("./view/footer.php"); ?>

	</body>
</HTML>