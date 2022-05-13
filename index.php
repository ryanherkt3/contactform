<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Contact Form</title>
	
	<!-- CSS/stylesheet code !-->
	<?php
		echo '<link rel = "stylesheet" href = "style.css" type = "text/css">';
	?>
</head>

<h1>Contact Form</h1>

<body>
	<!-- improvement: action to external php file !-->
	<!-- keep values if error has been made !-->
	<form action="index.php" method="POST">
		<label for="name">Name:</label>
		<span class="error">*</span>
		<input type="text" name="name" id="name" value="<?php echo isset($_POST["name"]) ? $_POST["name"] : ''; ?>" required>
        <br></br>
		
		<label for="email">Email:</label>
        <span class="error">*</span>
		<input type="text" name="email" id="email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] : ''; ?>" required>
        <br></br>

        <label for="subject">Subject:</label>
		<input type="text" name="subject" id="subject" value="<?php echo isset($_POST["subject"]) ? $_POST["subject"] : ''; ?>">
		<br></br>
		
		<label for="message">Your message:</label>
		<span class="error">*</span>
        <textarea placeholder="Message..." name="message" id="message" value="<?php echo isset($_POST["message"]) ? $_POST["message"] : ''; ?>" required></textarea>
        		
		<div id="button">
			<input type="submit" id="submit" name="submit">
		</div>
	</form>

</body>
</html>

<?php
	//Step One - connect to MySQL and create database:
	$conn = mysqli_connect('localhost', 'root', '');
	mysqli_query($conn, "CREATE DATABASE IF NOT EXISTS contactformdb;");
	
	//Step Two - create the table:
	$db = mysqli_select_db($conn, 'contactformdb');
	mysqli_query($conn, "CREATE TABLE IF NOT EXISTS form
	(
	id int NOT NULL AUTO_INCREMENT,
    fullname varchar(255),
	email varchar(30),
	usersubject varchar(255),
    usermessage varchar(255),
	PRIMARY KEY (id)
	);");
	
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']))
	{
		//check if user entered all the values
		if ((($_POST['name']) === '') or (($_POST['email']) === '') or (($_POST['message']) === ''))
		{
			//
		}
		else
		{
			$name = $_POST['name'];
            $email = $_POST['email'];
            $subject = $_POST['subject'];
            $message = $_POST['message'];

            //check if email address is valid (if statement)
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
            {
                echo "Invalid email format";
            }
            else
            {    
                $sql = "INSERT INTO form (fullname, email, usersubject, usermessage) VALUES ('$name', '$email', '$subject', '$message');";
                $query = mysqli_query($conn, $sql);

                //redirect back to form page
				header("Location: index.php?sent");

                //this bit needs a web domain/host
                //$mailTo = "ryan@webhost.com";
                //$headers = "From: ".$email;
                //$txt = "You have received an e-mail from ".$name.".\n\n".$message;
                //mail($mailTo, $subject, $txt, $headers);
		    }
        }
	}