window.onload = function() {
    //construct a Prototype Ajax.request object
    $("b_xml").onclick=function(){
        var radioBtn = $$("div#category label input");
        new Ajax.Request("books.php",{
            method:"GET",
            parameters:{category:getCheckedRadio(radioBtn)},
            onSuccess: showBooks_XML,
            onFailure: ajaxFailed,
            onException: ajaxFailed
        });
    }
    //construct a Prototype Ajax.request object
    $("b_json").onclick=function(){
        var radioBtn = $$("div#category label input");
        new Ajax.Request("books_json.php",{
            method:"GET",
            parameters:{category:getCheckedRadio(radioBtn)},
            onSuccess: showBooks_JSON,
            onFailure: ajaxFailed,
            onException: ajaxFailed 
        });
    }
};


function getCheckedRadio(radio_button){
    for (var i = 0; i < radio_button.length; i++) {
        if(radio_button[i].checked){
            return radio_button[i].value;
        }
    }
    return undefined;
}

function showBooks_XML(ajax) {
        //clear the previous list
        var books = document.getElementById("books");
        var booksChild = books.lastElementChild;
        while(booksChild){
            books.removeChild(booksChild);
            booksChild = books.lastElementChild;
        }
        var items = ajax.responseXML.getElementsByTagName("book");
        for(var i=0;i<items.length;i++){
            var title = items[i].getElementsByTagName("title")[0].firstChild.nodeValue;
            var author = items[i].getElementsByTagName("author")[0].firstChild.nodeValue;
            var year =  items[i].getElementsByTagName("year")[0].firstChild.nodeValue;
            var li = document.createElement("li");
            li.innerHTML = title + ", by " + author + " (" + year + ")";
            books.appendChild(li);
        }
    }
    function showBooks_JSON(ajax) {
        var books = document.getElementById("books");
        var booksChild = books.lastElementChild;
        while(booksChild){
            books.removeChild(booksChild);
            booksChild = books.lastElementChild;
        }
        var data = JSON.parse(ajax.responseText);
        for(var i=0;i<data.books.length;i++){
            var li = document.createElement("li");
            li.innerHTML = data.books[i].title  + ", by " + data.books[i].author + " (" + data.books[i].year + ")";
            $("books").appendChild(li);
        }
   }

   function ajaxFailed(ajax, exception) {
       var errorMessage = "Error making Ajax request:\n\n";
       if (exception) {
          errorMessage += "Exception: " + exception.message;
      } else {
          errorMessage += "Server status:\n" + ajax.status + " " + ajax.statusText + 
          "\n\nServer response text:\n" + ajax.responseText;
      }
      alert(errorMessage);
  }
