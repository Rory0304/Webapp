function alertBtn(){
	setInterval(function(){
		var x = $("textarea").style.fontSize;
		if(x==""){
			$("textarea").style.fontSize = "12pt";
		}
		else{
			$("textarea").style.fontSize = (parseInt(x) + 2) + "pt";
		}
	},5000);
}


function styleBtn(){
	if($("checkbox").checked){
		$("textarea").style.fontWeight = "bold";
		$("textarea").style.color = "green";
		$("textarea").style.textDecoration = "underline";
	}else{
		$("textarea").style.fontWeight = "";
		$("textarea").style.color = "";
		$("textarea").style.textDecoration = "";
	}
}

function snoopify(){
	var string = $("textarea").value;
	var str = string.split("");
	for(var i=0;i<str.length;i++){
		if(str[i]=="."){
			str[i] = "-izzle.";
		}
	}
	$("textarea").value = str.join("");
}

function pageLoad(){
	$("bp").onclick = alertBtn;
	$("checkbox").onclick = styleBtn;
	$("sn").onclick = snoopify;
}

window.onload = pageLoad;