var time;
$(document).ready(function() {
  if ($("#contain li").length > 5){
      append_clone();
  }
  pageScroll();
  $("#contain").mouseover(function() {
    clearTimeout(time);
  }).mouseout(function() {
    pageScroll();
  });
});

function append_clone(){
  $("#contain li").each(function(){
    $("#contain li").clone().appendTo("#contain");
  });
}

function pageScroll() {

	var objDiv = document.getElementById("contain");
  objDiv.scrollTop = objDiv.scrollTop + 1;
  if (objDiv.scrollTop == (objDiv.scrollHeight - 625)) { //valor=elemento css
      objDiv.scrollTop = 0;
  }
  time = setTimeout('pageScroll()', 100);
}
