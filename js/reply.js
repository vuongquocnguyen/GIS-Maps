$(document).ready(function(){
    $(".rep-a").click(function(){
        id=$(this).attr("data-a");
        $(".rep-form"+id).slideToggle();
    });
    $(".rep-submit").click(function(){
        id = $(this).attr("data-comid");
        m = $(".rep-mess"+id).val();
        n = $(".rep-submit").attr("data-namerep");
        $.ajax({
            url:"php/content/xuly_reply.php",
            type:"post",
            data:"mess="+m+"&name="+n+"&com_id="+id,
            async:true,
            success:function(kq){
               alert("Bình luận thành công!");
               $(".rep-list"+id).append(kq);
              $(".rep-mess"+id).val("");
           }
         })
        return false;
   });
});