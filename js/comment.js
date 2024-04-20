$(document).ready(function(){
         $(".com-submit").click(function(){
             m = $(".com-mess").val();
             n = $(".com-submit").attr("data-name");
             id = $(".com-submit").attr("data-idbaidang");
             $.ajax({
                 url:"php/content/xuly_comment.php",
                 type:"post",
                 data:"mess="+m+"&name="+n+"&id="+id,
                 async:true,
                 success:function(kq){
                    alert("Bình luận thành công!");
                    $("ul li:eq(3)").before(kq);
                    $(".com-mess").val("");
                }
              })
             return false;
        });
});