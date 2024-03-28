<?php
if(isset($_POST['id']) && isset($_POST['action'])){
    include('connect.php');
    $sql="select * from baidang_diendan where id_baidang = ".$_POST['id'].";";
    $retval=mysqli_query($conn,$sql); 
if(mysqli_num_rows($retval) > 0){
    $row=mysqli_fetch_array($retval);
    if($row) {
        //lay luot like va dislike
        $like    = intval($row['luot_like']);
        $dislike = intval($row['luot_dislike']);
         //cập nhật lại lượt like ,dislike
         $action = $_POST['action'];
         $sql = '';
         if($action == 'like')
         {
             $like = $like + 1;
             $sql = "UPDATE baidang_diendan SET luot_like='".$like."' WHERE id_baidang = ".$_POST['id'].";" ; 
        }elseif ($action == 'dislike')
        {
            $dislike = $dislike + 1;
            $sql = "UPDATE baidang_diendan SET luot_dislike='".$dislike."' WHERE id_baidang = ".$_POST['id'].";" ; 
        }
        //thuc hien truy van cau lenh update
            if($sql != '')
            {
                $retval2=mysqli_query($conn,$sql);
            }
        }
    } echo "<i class='far fa-thumbs-up'></i> Like $like"; echo "  <i class='far fa-thumbs-down'></i> Dislike $dislike ";
}else echo "Không có kết quả!";
?>