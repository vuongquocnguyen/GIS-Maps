 <style>
 .swiper-container{
     padding:10px 0 10px 0;
 }
 .swiper-slide img{
     height: auto;
     width:100%;
     border:5px solid #fff;
 }
 .swiper-button-next{
     width: 30px;
     height: 70px;

     transform: translateY(-50%);
     left: auto;
     margin-top: 0;
     right: 0;
     border-radius: 3px 0 0 3px;
    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMiAyMiI+PHBhdGggZD0iTTEuOSAyMmMtLjUgMC0xLS4yLTEuMy0uNkMuMiAyMSAwIDIwLjUgMCAyMGMwLS41LjItMSAuNi0xLjRMNy41IDExIC42IDMuNUMuMiAzLjEgMCAyLjUgMCAyUy4yIDEgLjYuNkMxLjItLjEgMi4zLS4yIDMgLjRsLjIuMiA4LjMgOWMuNy44LjcgMi4xIDAgMi45bC04LjMgOWMtLjMuMy0uOC41LTEuMy41eiIgZmlsbD0iIzQyNjdiMiIvPjwvc3ZnPg==");
    background-size: 12px 22px;
    background-position: center;
    background-repeat: no-repeat
 }

 .swiper-button-prev{
    width: 30px;
     height: 70px;
     transform: translateY(-50%) rotate(180deg);
     left: 0;
     right: auto;
     margin-top: 0;
     border-radius: 3px 0 0 3px;
    background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMiAyMiI+PHBhdGggZD0iTTEuOSAyMmMtLjUgMC0xLS4yLTEuMy0uNkMuMiAyMSAwIDIwLjUgMCAyMGMwLS41LjItMSAuNi0xLjRMNy41IDExIC42IDMuNUMuMiAzLjEgMCAyLjUgMCAyUy4yIDEgLjYuNkMxLjItLjEgMi4zLS4yIDMgLjRsLjIuMiA4LjMgOWMuNy44LjcgMi4xIDAgMi45bC04LjMgOWMtLjMuMy0uOC41LTEuMy41eiIgZmlsbD0iIzQyNjdiMiIvPjwvc3ZnPg==");
    background-size: 12px 22px;
    background-position: center;
    background-repeat: no-repeat
 }
 </style>
 <!-- Swiper -->

  <div class="swiper-container" >

    <div class="swiper-wrapper">
      <div class="swiper-slide"><img src="upload/me.jpg"></div>
      <div class="swiper-slide"><img src="upload/5afb36a294cff.jpg"></div>
      <div class="swiper-slide"><img src="upload/1.jpg"></div>
      <div class="swiper-slide"><img src="upload/2.jpeg"></div>
      <div class="swiper-slide"><img src="upload/3.jpg"></div>
      <div class="swiper-slide"><img src="upload/5afb36a294cff.jpg"></div>
      <div class="swiper-slide"><img src="upload/4.jpg"></div>
      <div class="swiper-slide"><img src="upload/5afb36a294cff.jpg"></div>
      <div class="swiper-slide"><img src="upload/5.jpg"></div>
      <div class="swiper-slide"><img src="upload/5afb36a294cff.jpg"></div>
    </div>
    <span class="swiper-pagination"></span>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>

  <!-- Swiper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.2/js/swiper.min.js"></script>
  <!-- Initialize Swiper -->
  <script>
    var swiper = new Swiper('.swiper-container', {
        nextButton: ".swiper-button-next",
        prevButton: ".swiper-button-prev",
        slidesPerView: 3,
        slidesPerGroup: 3,
        spaceBetween: 26,
        effect: 'coverflow',
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