<?php

	include("connect.php");
	include("functions.php");
	
	if(logged_in())
	{
		header("location:profile.php");
		exit();
	}
	
	$error = "";

	if(isset($_POST['submit']))
	{
		$firstName = mysqli_real_escape_string($con, $_POST['fname']);
		$lastName = mysqli_real_escape_string($con, $_POST['lname']);
	    $email = mysqli_real_escape_string($con, $_POST['email']);
	    $password = $_POST['password'];
	    $passwordConfirm = $_POST['passwordConfirm'];
	  
		$image = $_FILES['image']['name'];
	    $tmp_image = $_FILES['image']['tmp_name'];
	    $imageSize = $_FILES['image']['size'];
				
		$conditions = isset($_POST['conditions']);
		
		$date = date("F, d Y");
		
		
		if(strlen($firstName) < 3)
		{
			$error = "First name is too short";
		}
		
		else if(strlen($lastName) < 3)
		{
			$error = "Last name is too short";
		}
		else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error = "Please enter valid email address";
		}
		else if(email_exists($email, $con))
		{
			$error = "Someone is already registered with this email";
		}
		else if(strlen($password) < 8)
		{
			$error = "Password must be greater than 8 characters";
		}
		else if($password !== $passwordConfirm)
		{
			$error = "Password does not match";
		}
		else if($image == "")
		{
			$error = "Please upload your image";
		}
		else if($imageSize > 1048576)
		{
			$error = "Image size must be less than 1 mb";
		}			
		else if(!$conditions)
		{
			$error = "You must be agree with the terms and conditions";
		}
		else
		{	
				$password = password_hash($password, PASSWORD_DEFAULT);
				
				$imageExt = explode(".", $image);
				$imageExtension = $imageExt[1];
				
				if($imageExtension == "PNG" || $imageExtension == "png" || $imageExtension == "JPG" || $imageExtension == "jpg")
				{
					$image = rand(0, 100000).rand(0, 100000).rand(0, 100000).time().".".$imageExtension;
				
					$insertQuery = "INSERT INTO users(firstName, lastName, email, password, image, date) VALUES ('$firstName','$lastName','$email','$password','$image','$date')";
					if(mysqli_query($con, $insertQuery))
					{
						if(move_uploaded_file($tmp_image,"images/$image"))
						{
							$error = "You are successfully registered";
						}
						else
						{
							$error = "Image is not uploaded";
						}
					}
				}
				else
				{
					$error = "File must be an image";
				}
		}
							
	}

?>



<!doctype html>

<html>
	
	<head>
     
    <title>Registration Page</title>
	<link rel="stylesheet" href="css/registration.css">
	<link href="https://fonts.googleapis.com/css?family=Exo+2" rel="stylesheet">

	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>A Wedding Planner</title>
    <link rel="shortcut icon" href="img/favicon.ico" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="../css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Pacifico|Poiret+One" rel="stylesheet">   


	</head>

	<header>

        <nav class="navbar navbar-expand-lg navbar-light bg-faded">
            <div class="container">
            <a class="navbar-brand" href="#">
            <img src="../img/tietheknotlogo150x120.png" width="150" height="120" alt="">
            </a> 
                  <a class="navbar-brand" href="../index.html">A Step By Step Wedding Planner</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto navigation-menu ">
                       <li class="nav-item ">
                            <a class="nav-link" href="../index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../features.html">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.html">About <span class="sr-only">(current)</span></a>
                        </li>
              
                       <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown 
                        </a>
                            <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </li> -->
                    </ul>
                    <!--<form class="form-inline">
                        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                    </form> -->
                </div>
            </div>
        </nav>



	</header>

	
<body>

		<div id="error" style=" <?php  if($error !=""){ ?>  display:block; <?php } ?> "><?php echo $error; ?></div>
		
		<div id="wrapper">
			
			<div id="menu">
				<a href="index.php">Sign Up</a>
				<a href="login.php">Login</a>
			</div>
			
			<div id="formDiv">
				
				<form method="POST" action="index.php" enctype="multipart/form-data">
				
				<label>First Name:</label><br/>
				<input type="text" name="fname" class="inputFields" required/><br/><br/>
				
				<label>Last Name:</label><br/>
				<input type="text" name="lname"  class="inputFields" required/><br/><br/>
				
				<label>Email:</label><br/>
				<input type="text" name="email"  class="inputFields" required/><br/><br/>
				
				<label>Password:</label><br/>
				<input type="password" name="password" class="inputFields"  required/><br/><br/>
				
				<label>Re-enter Password:</label><br/>
				<input type="password" name="passwordConfirm"  class="inputFields" required/><br/><br/>
				
				<label>Image:</label><br/>
				<input type="file" name="image" id="imageupload"/><br/><br/>
				
			
				<input type="checkbox" name="conditions" />
				<label>I agree with terms and conditions</label><br/><br/>
				
				<input type="submit"  class="theButtons"  name="submit" />

				
				
				</form>
			
			</div>
		
		</div>
	

<!-- SCRIPTS -->
    <!-- JQuery -->
    <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
    <!-- Popper -->
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>	

	</body>

</html>

<!--<form method="POST" action="index.php" enctype="multipart/form-data">The enctype is needed to upload files or images-->
<!--<label>First Name:</label>  Label tag is new in html5-->