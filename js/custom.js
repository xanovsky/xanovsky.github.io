$.fn.exists = function () {
    return this.length > 0 ? this : false;
};

$(document).ready(function() {
  $(".tooltips").tooltip();

  var SidebarAnim = new TimelineLite({paused:true});
  SidebarAnim
      .to($("#main-nav"), 0.2, {left: 0})
      .to($("#main"), 0.2, {left: 250, right: "-=250"}, "-=0.2");
	
  $("a.mobilemenu").on("click", function() {
    SidebarAnim.play();
  });
  $("#main-nav, #main").on("click", function(){
    SidebarAnim.reverse();
  });
});
