<?php
$top=10;
include('connect.php');
$sql="SELECT baidang_diendan.noidung, baidang_diendan.hinhanh, baidang_diendan.id_baidang, baidang_diendan.viewcount, COUNT(comment.id_baidang), baidang_diendan.viewcount+COUNT(comment.id_baidang) as tong_xem_cmt FROM baidang_diendan left join comment on baidang_diendan.id_baidang = comment.id_baidang GROUP by baidang_diendan.id_baidang ORDER BY tong_xem_cmt DESC";
$retval=mysqli_query($conn,$sql);
$count=0;
echo "<div class='tieude' id='nav'>Top bài đăng</div>";
echo '<div class="swiper-container2" >';
echo '<div class="swiper-wrapper">';
if(mysqli_num_rows($retval)>0){
    while($row=mysqli_fetch_assoc($retval)){
        $row['noidung']=substr($row['noidung'],0,25);
        ++$count;
        echo " 
        <div class='top10 swiper-slide'> 
            <h3>{$count}</h3>
            <hr style='margin:7px;'/>
            <center>
                <a href='forum.php?xem=chitietbaidang&id=".$row['id_baidang']."'><img src='upload/".$row['hinhanh']."' /></a>
            </center>
            <p>{$row['noidung']}...</p>
        </div>";
        if($count==$top) break;
    }
} else echo "Không có kết quả!!!";
echo "</div>";
echo '    <span class="swiper-pagination"></span>';
echo "</div>";
?>
<style>
.swiper-container2{
     width: 100%;
     height: 99vh;
 }
 .wiper-container2 .swiper-slide img{
     height: auto;
     width:100%;
     border:5px solid #fff;
 }
</style>
  <!-- Swiper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js"></script>
  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container2', {
        slidesPerView: 4,
        slidesPerGroup: 4,
        spaceBetween: 26,
        direction: 'vertical',
        mousewheel: true,
        autoplay:2500,

        paginationClickable: true,
        pagination: '.swiper-pagination',
                paginationType: 'fraction',
                // paginationCustomRender: function (swiper, current, total) {
                //     return 'Trang ' + current +
                //         '/' +
                //          total + 'Trang';
                // }
    });

   
  </script>