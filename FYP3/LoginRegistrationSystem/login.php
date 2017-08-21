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
	
	    $email = mysqli_real_escape_string($con, $_POST['email']);
	    $password = mysqli_real_escape_string($con, $_POST['password']);
		$checkBox = isset($_POST['keep']);
		
		if(email_exists($email,$con))
		{
			$result = mysqli_query($con, "SELECT password FROM users WHERE email='$email'");
			$retrievepassword = mysqli_fetch_assoc($result);
			
			if(!password_verify($password, $retrievepassword['password']))
			{
				$error = "Password is incorrect";
			}
			else
			{
				$_SESSION['email'] = $email;
				
				if($checkBox == "on")
				{
					setcookie("email",$email, time()+3600);
				}
				
				header("location: profile.php");
			}
			
			
		}
		else
		{
			$error = "Email Does not exists";
		}
		
	
	}

?>



<!doctype html>

<html>
	
	<head>
		
	<title>Login Page</title>
	<link rel="stylesheet" href="css/registration.css"  />
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
                  <a class="navbar-brand" href="#">A Step By Step Wedding Planner</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto navigation-menu ">
                       <li class="nav-item  ">
                            <a class="nav-link" href="../index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../features.html">Features</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../about.html">About </a>
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
				
				<form method="POST" action="login.php">
				
				<label>Email:</label><br/>
				<input type="text" class="inputFields"  name="email" required/><br/><br/>
				
				
				<label>Password:</label><br/>
				<input type="password" class="inputFields"  name="password" required/><br/><br/>
				
				<input type="checkbox" name="keep" />
				<label>Keep me logged in</label><br/><br/>
			   
				<input type="submit" name="submit" class="theButtons" value="login" />

				
				
				</form>
			
			</div>
		
		</div>
		
	</body>

</html>