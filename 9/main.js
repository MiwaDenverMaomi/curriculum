$('.btn').click(function () {
  $(this).toggleClass("active");
  let flg = $(this).hasClass("active");

  if (flg === true) {
    open();
  } else {
    close();
  }
})

let open=()=>{
    $(".bg-left").animate({width:'0%'},2000 );
    $(".bg-right").animate({width:'0%'},2000 );
}
let close=()=> {
    $(".bg-left").animate({width:'50%'},2000 );
    $(".bg-right").animate({width:'50%'},2000 );
}

//トライしてみた処理方法※うまくいかない
// function slideBackground() {
//   const $left = $('.bg-left ');
//   const $right = $('.bg-right ');
//   if ($left.hasClass("close") && $right.hasClass("close")) {
//     $left.removeClass("close");
//     $right.removeClass("close");
//     $left.addClass("open");
//     $right.addClass("open");
//   } else{
//     $left.removeClass("open");
//     $right.removeClass("open");
//     $left.addClass("close");
//     $right.addClass("close");
//   }
// }
