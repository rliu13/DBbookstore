
<!-- HTML by Andrew Moots & Miroslav Pavlovski w/ outline from Prithviraj Narahari & Alexander Martens & Bootstrap -->
<html>
	<head>
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
		<link rel="stylesheet" href="/css/custom.css">

		<meta name="viewport" content="width=device-width, initial-scale=1.0">

		<title>SEARCH - 3-B.com</title>
	</head>
	<body class="d-flex flex-column min-vh-100">
        
        <?php include("./view/header.php"); ?>

		<div class="container-fluid">
			<div class="standard-container bg-white shadow">
			<form action="process3.php" method="POST">
				<h1 class="h3 mb-3 fw-normal">New Search</h1>
				<div class="row">
					<div class="col-md-3">
						<div class="d-flex align-items-center" style="height: 100%;">
							<b>Search For:</b>
						</div>
					</div>
					<div class="col-md-6">
						<input type="text" class="form-control" name="searchText" id="inputSearch" required placeholder="Title, Author, etc...">
					</div>
					<div class="col-md-3 text-end">
						<input type="submit" class="btn btn-md btn-primary" ></button>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">
						<div class="d-flex align-items-center" style="height: 100%;">
							<b>Search In:</b>
						</div>
					</div>
					<div class="col-md-6">
						<select class="form-select" name="searchIn[]" multiple aria-label="multiple select example">
							<option value="anywhere" selected='selected'>Keyword anywhere</option>
							<option value="title">Title</option>
							<option value="author">Author</option>
							<option value="publisher">Publisher</option>
							<option value="isbn">ISBN</option>	
						</select>
					</div>
					<div class="col-md-3 text-end">
						<a class="btn btn-md btn-secondary" href="shopping_cart.php">Manage Shopping Cart</a>
					</div>
				</div>
				<br/>
				<div class="row">
					<div class="col-md-3">
						<div class="d-flex align-items-center" style="height: 100%;">
							<b>Category:</b>
						</div>
					</div>
					<div class="col-md-6">
						<select name="category" id="inputState" class="form-select">
							<option selected value='All'>All Categories</option>
							<option value='Fantasy'>Fantasy</option>
							<option value='Adventure'>Adventure</option>
							<option value='Fiction'>Fiction</option>
							<option value='Horror'>Horror</option>
						</select>
					</div>
					<div class="col-md-3 text-end">
						<a class="btn btn-md btn-warning" href="index.php">Exit 3-B.com</a>
					</form>
					</div>
				</div>
			</div>
		</div>

		<?php include("./view/footer.php"); ?>

	</body>
</html>
