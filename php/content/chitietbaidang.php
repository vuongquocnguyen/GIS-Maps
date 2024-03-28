<?php
$con_name=$_SESSION['nguoidung'];
$id=$_GET['id'];
?>
<style>
    #chitietbaidang #result i{
        margin-left:10px;
    }
</style>
<script>
    $(document).ready(function()
{
    $("a.button_like").click(function()
    {
        var id     = $(this).attr("id_baidang"); //lay id video
        var action = $(this).attr("action"); //lay hanh dong like hoac dislike
        var data   = 'id='+ id + '&action='+ action; //du lieu gui sang server
 
        $("#result").html('Loadding...');
 
        //cap nhat lai so luong like, dislike
        var count_like = $(this).find('b').text();
        count_like = parseInt(count_like) + 1;
        $(this).find('b').text(count_like);
        $.ajax
        ({
            type: "POST",
            url: "php/content/like.php",
            data: data,
            success: function(html)
            {   
                $("#result").html(html);
            }
        });
    });
});
</script>

<?php
#-----------------------Hiển thị danh sách thông báo-------------
include("connect.php");
    $sql="SELECT * FROM baidang_diendan where id_baidang=$id";
	$retval=mysqli_query($conn, $sql);
	if(mysqli_num_rows($retval) > 0){	
		while($row = mysqli_fetch_assoc($retval)){
            $sql2="UPDATE baidang_diendan SET viewcount=viewcount+1 WHERE id_baidang=$id";
            $retval2=mysqli_query($conn, $sql2);
            echo  "<div id='chitietbaidang'><h4>".$row['chude']."</h4>
                    <center>
                        <div class='hinhanh'><img src='upload/".$row['hinhanh']."'/></div>
                    </center> 
                            <p>".$row['noidung']."</p><hr>
                        <p class='ngaydang'>Ngày Đăng:".$row['ngaydang']."</p><p class='tacgia'> Người Đăng:".$row['nguoidang']."</p><hr>
                        <div class='tuongtac'> 
                            <p id='result'>  
                                <a href='javascript:void(0)' class='button_like' action='like' id_baidang='".$row['id_baidang']."'><i class='far fa-thumbs-up'></i> Like <b>".$row['luot_like']."</b></a> 
                                <a href='javascript:void(0)' class='button_like' action='dislike' id_baidang='".$row['id_baidang']."'><i class='far fa-thumbs-down'></i> Dislike <b>".$row['luot_dislike']."</b></a> 
                            </p>
                        </div>                   
                </div>";
		}	
}else echo "Không có thông báo!";	
mysqli_close($conn);
?>
<style>
    #cmt{
        width:80%;
        height:auto;
        margin-left:5%;
    }
    .com-mess{
        height:100px;
        width:100%;
    }
    .com-name{
        height:20px;
        width:350px;
    }
    .avt-comment{ 
        width:30px;
        height:auto;
        float:left;
        margin-top: 10px;
    }
    .avt-reply{ 
        width:30px;
        height:auto;
        float:left;
        margin-top: 10px;

    }
    #cmt li div{
        float:left;
        margin-left:5px;
    }
    #cmt ul li{
        clear:left;
    }
    #cmt li ul li{
        padding-top:0;
    }
    .rep-mess{
        height:50px;
        width:250px;
    }
</style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="js/comment.js"></script>
<script src="js/reply.js"></script>
<div id="cmt">
    <fieldset style="width:430px; margin-left:10px; margin-top:2%;">
        <legend>Your Comment</legend>
            <form action="#" method="POST" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Content:</td>
                        <td><textarea class="com-mess" rows='10' cols='50'></textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Comment" class="com-submit" data-name="<?php echo $con_name; ?>" data-idbaidang="<?php echo $id; ?>" /></td>
                    </tr>
                </table>
            </form>
    </fieldset>
    <fieldset style="width:420px; margin-left:10px; margin-top:2%; padding: 0 0 8px 2px;">
        <legend>Old Comment</legend>
            <ul style="list-style:none;">
            <?php
                require("connect.php");
                $sql="select com_id, com_name, com_mess, com_date from comment where id_baidang=$id order by com_id desc";
                $retval=mysqli_query($conn, $sql);
                if(mysqli_num_rows($retval) > 0){	
                    while($row = mysqli_fetch_assoc($retval)){
                        $sql3="Select hinhanh from taikhoan where tentaikhoan='".$row['com_name']."'";
                        $retval3=mysqli_query($conn,$sql3);
                        $hinhanh=mysqli_fetch_assoc($retval3);
                        echo "<li>";
                        //Nội dung bình luận
                                echo "<img src='upload/".$hinhanh['hinhanh']."' class='avt-comment'/>";
                                echo "<div>";
                                $timestamp=strtotime($row['com_date']);
                                $date=date('d/m/Y',$timestamp);
                                    echo "<b>".$row['com_name']."</b>&nbsp;<small>".$date."</small>&nbsp;<a href='javascript:void(0)' class='rep-a' data-a='$row[com_id]'>Reply</a>";
                                    $mess=nl2br($row['com_mess']);
                                    echo "<p>".$mess."</p>";
                                echo "</div>";
                                //Nội dung reply
                                echo "<ul style='list-style:none;' class='rep-list$row[com_id]'>";
                                $sql2="select rep_name, rep_mess, rep_date from reply where com_id=$row[com_id]";
                                $retval2=mysqli_query($conn, $sql2);
                                    while($row2 = mysqli_fetch_assoc($retval2)){
                                        $sql4="Select hinhanh from taikhoan where tentaikhoan='".$row2['rep_name']."'";
                                        $retval4=mysqli_query($conn,$sql4);
                                        $hinhanh2=mysqli_fetch_assoc($retval4);
                                        echo "<li>";
                                        //Nội dung bình luận
                                        echo "<img src='upload/".$hinhanh2['hinhanh']."' class='avt-reply' />";
                                                echo "<div>";
                                                $timestamp=strtotime($row2['rep_date']);
                                                $date2=date('d/m/Y',$timestamp);
                                                    echo "<b>".$row2['rep_name']."</b>&nbsp;<small>".$date2."</small>&nbsp";
                                                    $mess2=nl2br($row2['rep_mess']);
                                                    echo "<p>".$mess2."</p>";
                                                echo "</div>";
                                            echo "</li>";  
                                            }
                                echo "</ul>";   
                                echo "<fieldset style='width:250px; margin-left:10px; margin:auto; padding: 0 0 8px 18px; display:none;' class='rep-form$row[com_id]'>
                                            <legend>Your Reply</legend>
                                                <form>
                                                    <table>
                                                        <tr>
                                                            <td>Content:</td>
                                                            <td class='rep-mess'><textarea class='rep-mess$row[com_id]'></textarea></td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td><input type='submit' value='Comment' class='rep-submit' data-namerep='$con_name' data-comid='$row[com_id]'/></td>
                                                        </tr>
                                                    </table>
                                                </form>
                                    </fieldset> ";
                        echo "</li>";
                    }
                }else echo "Chưa có bình luận nào!";	
                mysqli_close($conn);
                ?>
            </ul>
    </fieldset>
</div>