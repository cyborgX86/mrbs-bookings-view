var time;
$(document).ready(function() {
  pageScroll();
  $("#contain").mouseover(function() {
    clearTimeout(time);
  }).mouseout(function() {
    pageScroll();
  });
});

function pageScroll() {
	var objDiv = document.getElementById("contain");
  objDiv.scrollTop = objDiv.scrollTop + 1;
  $('p:nth-of-type(1)').html('scrollTop : '+ objDiv.scrollTop);
  $('p:nth-of-type(2)').html('scrollHeight : ' + objDiv.scrollHeight);
  if (objDiv.scrollTop == (objDiv.scrollHeight - 625)) { //valor=elemento css
      objDiv.scrollTop = 0;
  }
  time = setTimeout('pageScroll()', 100);
}
