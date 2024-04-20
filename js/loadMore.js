$(document).ready(function(){
    var flag = 0;
    $.ajax({
        url:"php/content/baidang.php",
        type:"GET",
        data: {
            'offset':0,
            'limit':8
        },
        success:function(data){
           $("#inner").append(data);
           flag += 8;
       }
     })
     $(window).scroll(function () {
        if ( $(window).scrollTop() >= $(document).height() - $(window).height()) {
            $.ajax({
                url:"php/content/baidang.php",
                type:"GET",
                data: {
                    'offset':flag,
                    'limit':2
                },
                success:function(data){
                   $("#inner").append(data);
                   flag += 2;
               }
             })
        }
        if ( $(window).scrollTop() >= $('#right').height() - $(window).height()){
            $('#right').css('position','fixed');
        }else{
            $('#right').css('position','unset');
        }
        if ( $(window).scrollTop()+ $(window).height() > $('#footer').offset().top){
    
        }
    });
});