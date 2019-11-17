<!DOCTYPE html>
<html lang="en">
<head>
	<title>Grade Store</title>
	<link href="https://selab.hanyang.ac.kr/courses/cse326/2019/labs/labResources/gradestore.css" type="text/css" rel="stylesheet" />
</head>

<body>

	<?php
	# Ex 4 : 
		# Check the existence of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
	$check = true;
	$values = ["name","id","Credit","grades","radio","checkbox"];
	foreach ($values as $value) {
		if(!isset($_POST[$value]) || $_POST[$value]==""){
			$check = false;
			break;
		}
	}

	if($check == false){?>
		<h1>Sorry</h1>
		<p>You didn't fill out the form completely. <a href="gradestore.html">Try again?</a></p>
	<?php }
	else {
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		# } elseif () { 
		$name = $_POST["name"];
		$credit = $_POST["Credit"];
		$type = $_POST["radio"];
		$pattern = "/^[a-zA-Z]+\s[a-zA-Z]+$/";
		if(!preg_match($pattern,$name)){?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="gradestore.html">Try again?</a></p>
		<?php }

		else if(!preg_match("/\d{16}/", $credit) || ($type=="Visa" && !preg_match("/^4/",$credit)) || ($type=="MasterCard" && !preg_match("/^5/",$credit))){?>
				<h1>Sorry</h1>
				<p>You didn't provide a valid credit card number. <a href="gradestore.html">Try again?</a></p>
		<?php }

		else{?>

			<h1>Thanks, looser!</h1>
			<p>Your information has been recorded.</p>

			<!-- Ex 2: display submitted data -->
			<ul> 
				<li>Name: <?= $_POST["name"]; ?></li>
				<li>ID: <?= $_POST["id"]; ?></li>
				<!-- use the 'processCheckbox' function to display selected courses -->
				<li>Course: <?= processCheckbox($_POST["checkbox"]); ?> </li>
				<li>Grade: <?= $_POST["grades"]; ?></li>
				<li>Credit: <?= $_POST["Credit"] . ' (' . $_POST["radio"] . ')'; ?> </li>
			</ul>
		
			<!--Ex 3 :
			/* Ex 3: 
			 * Save the submitted data to the file 'loosers.txt' in the format of : "name;id;cardnumber;cardtype".
			 * For example, "Scott Lee;20110115238;4300523877775238;visa"
			 */ -->
			 <p>Here are all the loosers who have submitted here:</p>

			 <?php
			 $filename = "loosers.txt";
			 $current = file_get_contents($filename);
			 $s = ($_POST["name"] . ";" . $_POST["id"] . ";" . $_POST["Credit"] . ";" . $_POST["radio"] . PHP_EOL);
			 $current .= $s;
			 file_put_contents($filename, $current);
			 ?>

		<!-- Ex 3: Show the complete contents of "loosers.txt".
			Place the file contents into an HTML <pre> element to preserve whitespace -->
			<?php
			$filename = "loosers.txt";
			$contents = file_get_contents($filename);
			echo "<pre>$contents</pre>";
			?>
			
	<?php }}?>

			<?php
			/* Ex 2: 
			 * Assume that the argument to this function is array of names for the checkboxes ("cse326", "cse107", "cse603", "cin870")
			 * 
			 * The function checks whether the checkbox is selected or not and 
			 * collects all the selected checkboxes into a single string with comma separation.
			 * For example, "cse326, cse603, cin870"
			 */
			function processCheckbox($names){
				$s = array();
				for($i=0;$i<count($names);$i++){
					if(isset($names[$i])){
						array_push($s, $names[$i]);
					}
				}
				$result = implode(", ", $s);
				return $result;
			}
			?>

		</body>
		</html>
