<?php
// CSE 326 Web Application Development 
// Lecture 13 Web Services - Exercise : Baby name web service

if (isset($_GET["type"])){
	$type = $_GET["type"];
	if($type != "list"){
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you passed in a wrong type parameter.");
	}
	nameList();
} else {
	babyname();
}

function nameList(){
	$names = "";
	$lines = file("rank.txt", FILE_IGNORE_NEW_LINES);
	foreach ($lines as $line) {
		$names = $names.substr($line, 0, strpos($line, " "))." ";
		//strpos($line," ") : $line에서 " "이 처음으로 나타내는 부분의 인덱스 값
	}
	
	if ($names) {
		header("Content-type: text/plain");	
		print trim($names);
	} else {
		header("HTTP/1.1 410 Gone");
		die("HTTP/1.1 410 Gone - There is no data!.");
	}
}


function babyname(){
	$name = get_parameter("name");
	$gender = get_parameter("gender");

	$baby_info = "";
	$lines = file("rank.txt", FILE_IGNORE_NEW_LINES);
	foreach ($lines as $line) {
		if (preg_match("/^$name $gender /", $line)) {
			$baby_info = $line;
			break;
		}
	}
	
	if ($baby_info) {
		// header("Content-type: text/xml");
		// generate_xml($line,$name,$gender);
		header("Content-type: application/json");
		genertate_Json($line,$name,$gender);

	} else {
		header("HTTP/1.1 410 Gone");
		die("HTTP/1.1 410 Gone - There is no data for this name/gender.");
	}
}

/* Creates and returns an XML DOM tree for the given line of data.
 * 
 * for the data, "Aaron m 147 193 187 199 250 237 230 178 52 34 34 41 55",
 * would produce the following XML: 
 * <baby name="Aaron" gender="m">
 *    <rank year="1890">147</rank>
 *    <rank year="1900">193</rank>
 *    ...
 * </baby>
 * 
 * Note that the year is from 1890 to 2010 and increasing by 10 for each record 
 */ 
function generate_xml($line, $name, $gender) {
	$xmldoc = new DOMDocument();
	$baby_tag = $xmldoc->createElement("baby");
	$baby_tag->setAttribute("name",$name);
	$baby_tag->setAttribute("gender",$gender);
	
	$year = 1890;

	$tokens = explode(" ", $line);
	for($i=2;$i<count($tokens);$i++){
		$rank_tag = $xmldoc->createElement("rank");
		$rank_tag->setAttribute("year",$year);
		$rank_tag->appendChild($xmldoc->createTextNode($tokens[$i]));
		$baby_tag->appendChild($rank_tag);
		$year+=10;
	}
	$xmldoc->appendChild($baby_tag);
	print $xmldoc->saveXML();
	return $xmldoc;
}

function genertate_Json($line,$name,$gender){
	$data = array();
	$data["name"] = $name;
	$data["gender"] = $gender;
	$line = explode(" ",$line);
	$line = array_slice($line,2); //앞에 2개 없앤다.
	$line = array_map(function($ele){return intval($ele);},$line);
	$data["rankings"] = $line;
	print json_encode($data);
}
function get_parameter($name) {
	if (isset($_GET[$name])) {
		return $_GET[$name];
	} else {
		header("HTTP/1.1 400 Invalid Request");
		die("HTTP/1.1 400 Invalid Request - you forgot to pass a '$name' parameter.");
	}
}
?>