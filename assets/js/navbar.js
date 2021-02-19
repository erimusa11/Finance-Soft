function navAnimation() {
  var tabsNewAnim = $("#navbarSupportedContent");
  var selectorNewAnim = $("#navbarSupportedContent").find("li").length;
  var activeItemNewAnim = tabsNewAnim.find(".active");
  var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
  var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
  var itemPosNewAnimTop = activeItemNewAnim.position();
  var itemPosNewAnimLeft = activeItemNewAnim.position();
  var url = window.location.href;
  var lastPartUrl = url.substring(url.lastIndexOf("/") + 1);

  $(".dropdown ul li a").each(function () {
    var thisUrl = $(this).attr("href");
    if (thisUrl == lastPartUrl) {
      $(".left, .right").hide();
    }
  });

  $(".hori-selector").css({
    top: itemPosNewAnimTop.top + "px",
    left: itemPosNewAnimLeft.left + "px",
    height: activeWidthNewAnimHeight + 14 + "px",
    width: activeWidthNewAnimWidth + "px",
  });
  $("#navbarSupportedContent").on("click", "li", function (e) {
    $("#navbarSupportedContent ul li").removeClass("active");
    if ($(this).hasClass("dropdown")) {
      $(".left, .right, .hori-selector").hide();
    } else {
      $(this).addClass("active");
      $(".hori-selector").show();
    }

    var activeWidthNewAnimHeight = $(this).innerHeight();
    var activeWidthNewAnimWidth = $(this).innerWidth();
    var itemPosNewAnimTop = $(this).position();
    var itemPosNewAnimLeft = $(this).position();
    $(".hori-selector").css({
      top: itemPosNewAnimTop.top + "px",
      left: itemPosNewAnimLeft.left + "px",
      height: activeWidthNewAnimHeight + 14 + "px",
      width: activeWidthNewAnimWidth + "px",
    });
  });
}
$(document).ready(function () {
  setTimeout(function () {
    navAnimation();
  });
});
$(window).on("resize", function () {
  setTimeout(function () {
    navAnimation();
  }, 500);
});
$(".navbar-toggler").click(function () {
  setTimeout(function () {
    navAnimation();
  });
});
