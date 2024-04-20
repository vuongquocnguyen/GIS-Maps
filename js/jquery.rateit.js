﻿$(document).ready(function(){
    
    /* 1. Visualizing things on Hover - See next part for action on click */
    $('#stars li').on('mouseover', function(){
      var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on
     
      // Now highlight all the stars that's not after the current hovered star
      $(this).parent().children('li.star').each(function(e){
        if (e < onStar) {
          $(this).addClass('hover');
        }
        else {
          $(this).removeClass('hover');
        }
      });
      
    }).on('mouseout', function(){
      $(this).parent().children('li.star').each(function(e){
        $(this).removeClass('hover');
      });
    });
    
    
    /* 2. Action to perform on click */
    $('#stars li').on('click', function(){
      ma_thongbao=$(this).attr("data-rate");
      var onStar = parseInt($(this).data('value'), 10); // The star currently selected
      var stars = $(this).parent().children('li.star');
      
      for (i = 0; i < onStar; i++) {
        $(stars[i]).addClass('selected');
      } 
      
      // JUST RESPONSE (Not needed)
      var ratingValue = parseInt($('#stars li.selected').last().data('value'), 10);
      var msg = "";
      if (ratingValue > 1) {
        if(confirm("Bạn muốn đánh giá "+ratingValue+" cho bài viết!")){
            $.ajax({
              url:"php/content/rating.php",
              type:"post",
              data:"rate="+ratingValue+"&mathongbao="+ma_thongbao,
              async:true,
              success:function(kq){
                alert("Bạn đã đánh giá thành công!");
            }
          })
        }else {for (i = 0; i < stars.length; i++) {
                    $(stars[i]).removeClass('selected');
                  }
                }
      }
    });
  });
  
  
  function responseMessage(msg) {
    $('.success-box').fadeIn(200);  
    $('.success-box div.text-message').html("<span>" + msg + "</span>");
  }