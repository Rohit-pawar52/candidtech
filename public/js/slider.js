var myVar = setInterval(myTimer, 5000);
function myTimer() {
  let lists = document.querySelectorAll('.itm');
   document.getElementById('slide').appendChild(lists[0]);
}
document.getElementById('next').onclick = function(){
    let lists = document.querySelectorAll('.itm');
    
    document.getElementById('slide').appendChild(lists[0]);
     clearInterval(myVar);
	myVar = setInterval(myTimer, 5000);
   // 
}

document.getElementById('prev').onclick = function(){
    let lists = document.querySelectorAll('.itm');
    document.getElementById('slide').prepend(lists[lists.length - 1]);
}
/*jQuery('.itm').click(function(){
	var target  = jQuery(this);

// the collection you're looking in
	var nodes = document.querySelectorAll(".itm");

	var index = [].indexOf.call(nodes, target);
	alert(index);
})*/
jQuery(function() {
jQuery('.slider .itm').click(function(e) {


  var el = $(this).index();
  /*;*/
  console.log(el);

  let lists = document.querySelectorAll('.itm');
  //document.getElementById('slide').prepend(lists[el]);
  jQuery( "#slide .itm:nth-child(1)" ).after( this );
  clearInterval(myVar);
  myVar = setInterval(myTimer, 5000);
 })
  });