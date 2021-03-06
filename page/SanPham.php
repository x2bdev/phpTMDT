﻿<?php
//    include("../layout/header.php");
//?>
<?php define('BASEURL','http://localhost:8080/banhang/banhang');?>
<!DOCTYPE html>
<html>
<head>
    <title>Khóa học online</title>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="<?php echo BASEURL?>../script/jsNguoiDung/jquery-1.11.0.min.js"></script>
    <!-- Custom Theme files -->
    <link href="<?php echo BASEURL?>../css/cssNguoiDung/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <script src="<?php echo BASEURL?>../script/jsNguoiDung/bootstrap.min.js"></script>
    <!--theme-style-->
    <link href="<?php echo BASEURL?>../css/cssNguoiDung/style.css" rel="stylesheet" type="text/css" media="all" />
    <!--//theme-style-->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Free Style Responsive web template, Bootstrap Web Templates, Flat Web Templates, Andriod Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyErricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!--fonts-->
    <link href='//fonts.googleapis.com/css?family=Alegreya+Sans+SC:100,300,400,500,700,800,900,100italic,300italic,400italic,500italic,700italic,800italic,900italic' rel='stylesheet' type='text/css'>
    <link href='//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic' rel='stylesheet' type='text/css'>
    <!--//fonts-->
    <script type="text/javascript" src="<?php echo BASEURL?>../script/jsNguoiDung/move-top.js"></script>
    <script type="text/javascript" src="<?php echo BASEURL?>../script/jsNguoiDung/easing.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $(".scroll").click(function(event){
                event.preventDefault();
                $('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
            });
        });
    </script>
    <!-- start menu -->
    <script src="<?php echo BASEURL?>../script/jsNguoiDung/simpleCart.min.js"> </script>
    <link href="<?php echo BASEURL?>../css/cssNguoiDung/memenu.css" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript" src="<?php echo BASEURL?>../script/jsNguoiDung/memenu.js"></script>
    <script>$(document).ready(function(){$(".memenu").memenu();});</script>

    <?php
    session_start();
    $GLOBALS['connect'] = mysqli_connect("localhost","root","", 'banhang_php');
    mysqli_set_charset($GLOBALS['connect'],"utf8");
    if(!$GLOBALS['connect'])
        echo "Kết nối thất bại";


    function phan_trang($tenCot,$tenBang,$dieuKien,$soLuongSP,$trang,$dieuKienTrang)
    {
        $spbatdau=$trang*$soLuongSP;

        $laySP=" SELECT ".$tenCot." FROM ".$tenBang." ".$dieuKien ." LIMIT ".$spbatdau.",".$soLuongSP;
        $truyvanLaySP = mysqli_query($GLOBALS['connect'], $laySP);

        $tongsoluongsp=mysqli_num_rows(mysqli_query($GLOBALS['connect'], " SELECT ".$tenCot." FROM ".$tenBang." ".$dieuKien));
        $tongsotrang=$tongsoluongsp/$soLuongSP;

        $dsTrang="";
        for($i = 0 ; $i < $tongsotrang; $i++)
        {
            $sotrang=$i+1;
            $dsTrang .=  "<a class='divtrang_".$i."' href='".$_SERVER["PHP_SELF"]."?trang=".$i.$dieuKienTrang."'>". $sotrang  . "</a> ";
        }

        echo "<script>
                $(document).ready(function(){
                    $('.divtrang').html(\"".$dsTrang."\")
                });
            </script>";

        return $truyvanLaySP;
    }

    if(isset($_GET["dx"]))
        unset($_SESSION["tendangnhap"]);

    if(isset($_GET["moiGH"]))
        unset($_SESSION["giohang"]);

    function DinhDangTien($dongia) //1000000
    {
        $sResult = $dongia;
        for ( $i = 3; $i < strlen($sResult); $i += 4)
        {
            $sSau = substr($sResult,strlen($sResult) - $i); // 000.000
            $sDau = substr($sResult,0, strlen($sResult) - $i); // 1
            $sResult = $sDau . "." . $sSau; // 1.000.000
        }
        return $sResult;
    }

    ?>
</head>
<body>
<!--top-header-->
<div class="top-header">
    <div class="container">
        <div class="top-header-main">
            <div class="col-md-4 top-header-left">
                <div class="search-bar">
                    <form method="post" action="<?php echo BASEURL?>../page/TimKiemSanPham.php">
                        <input name="tkTenSP" type="text" placeholder="Nhập tên khóa học...">
                        <input type="submit" value="">
                    </form>
                </div>
            </div>
            <div class="col-md-4 top-header-middle">
                <a href="../index.php"><img src="<?php echo BASEURL?>../images/logo-4.png" alt="" /></a>
            </div>
            <div class="col-md-4 top-header-right divgiohang">

                <?php
                if(isset($_SESSION["giohang"]))
                {
                    $tongsp=0;
                    $tongtien=0;
                    foreach($_SESSION["giohang"] as $cotGH)
                    {
                        $tongsp++;
                        $tongtien+=$cotGH["dongia"]*$cotGH["soluong"];
                    }
                    ?>
                    <div class="cart box_1">
                        <a href="<?php echo BASEURL?>../page/GioHang.php">
                            <h3> <div class="total">
                                    <span >$ <?php echo DinhDangTien($tongtien); ?> </span> (<span id="simpleCart_quantity" > <?php echo $tongsp; ?> </span> SP)</div>
                                <img src="<?php echo BASEURL?>../images/cart-1.png" alt="" />
                        </a>
                        <p><a href="<?php echo BASEURL?>../page/SanPham.php?moiGH=0" class="simpleCart_empty">Làm mới</a></p>
                        <div class="clearfix"> </div>
                    </div>
                    <?php
                }
                else{
                    ?>
                    <div class="cart box_1">
                        <a href="<?php echo BASEURL?>../page/GioHang.php">
                            <h3> <div class="total">
                                    <span >$ 0 </span> (<span id="simpleCart_quantity" > 0 </span> items)</div>
                                <img src="../images/cart-1.png" alt="" />
                        </a>
                        <p><a href="<?php echo BASEURL?>../page/SanPham.php?moiGH=0"  class="simpleCart_empty">Làm mới</a></p>
                        <div class="clearfix"> </div>
                    </div>
                <?php } ?>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!--top-header-->
<!--bottom-header-->
<div class="header-bottom">
    <div class="container">
        <div class="top-nav">
            <ul class="memenu skyblue"><li class="active"><a href="<?php echo BASEURL?>../index.php">Trang chủ</a></li>
                <li ><a href="<?php echo BASEURL?>../page/SanPham.php">Khóa học</a></li>
                <li class="grid"><a href="#">Danh mục</a>
                    <div class="mepanel">
                        <div class="row">
                            <div class="col1 me-one">
                                <h4>Danh Mục</h4>
                                <ul>
                                    <?php
                                    $layLoaiSP="SELECT * FROM loaisp";
                                    $truyvan_layLoaiSP= mysqli_query($GLOBALS['connect'], $layLoaiSP);
                                    while($cot= mysqli_fetch_array($truyvan_layLoaiSP))
                                    {
                                        ?>
                                        <li><a href="<?php echo BASEURL?>../page/DanhMucSanPham.php?loaisp=<?php echo $cot["MaLoaiSP"] ?>"><?php echo $cot["TenLoai"] ?></a></li>
                                        <?php
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="col1 me-one">
                                <h4>Giá</h4>
                                <ul>
                                    <li><a href="<?php echo BASEURL?>../page/DanhMucSanPham.php?gia=200000">Dưới 200.000</a></li>
                                    <li><a href="<?php echo BASEURL?>../page/DanhMucSanPham.php?gia=300000">Dưới 300.000</a></li>
                                    <li><a href="<?php echo BASEURL?>../page/DanhMucSanPham.php?gia=400000">Dưới 400.000</a></li>
                                    <li><a href="<?php echo BASEURL?>../page/DanhMucSanPham.php?gia=500000">Dưới 500.000</a></li>
                                </ul>
                            </div>
                            <div class="col1 me-one">
                                <ul class="sub1 anh1">
                                    <a href="">
                                        <img src="../images/1.jpg" alt="anh">
                                    </a>
                                    <p><a href=""></a>Khoá học rẻ nhất</a></p>
                                    <p class="price">$199.00</p>
                                </ul>
                            </div>
                        </div>
                    </div>
                </li>
                <?php if(!isset($_SESSION["tendangnhap"])) { ?>

                    <li ><a href="<?php echo BASEURL?>../page/DangKy.php">Đăng ký</a></li>
                    <li ><a href="#" data-toggle="modal" data-target=".bs-example-modal-lg">Đăng nhập</a></li>

                <?php }else{ ?>
                    <li ><a href="<?php echo BASEURL?>../page/ThongTinTaiKhoan.php"><span style="text-transform:none">Xin chào <?php echo $_SESSION["tendangnhap"]; ?></span></a> <a href="<?php echo $_SERVER["PHP_SELF"]; ?>?dx=0"> Đăng xuất</a></li>
                <?php } ?>
            </ul>
        </div>
        <div class="clearfix"> </div>
    </div>
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="padding: 50px">
            <form method="post" action="<?php echo BASEURL?>../page/DangNhap.php">
                <input type="hidden" name="tranghientai" value="<?php echo $_SERVER["PHP_SELF"]; ?>">
                <div class="account-top heading">
                    <h3>Đăng nhập</h3>
                </div>
                <div class="address">
                    <span>Tên đăng đăng nhập</span>
                    <input id="dn_tendangnhap" name="tendangnhap" type="text">
                </div>
                <div class="address">
                    <span>Mật khẩu</span>
                    <input id="dn_matkhau" name="matkhau" type="password">
                </div>
                <div class="address">
                    <span style="color: red;" id="dn_thongbao"></span>
                    <a class="forgot" href="<?php echo BASEURL?>../page/QuenMatKhau.php">Quên mật khẩu?</a>
                    <input id="dangnhap" type="submit" value="Đăng nhập">
                </div>
            </form>
            <script>
                $(document).ready(function(){
                    $('#dangnhap').click(function(){
                        dn_tendangnhap=$('#dn_tendangnhap').val();
                        dn_matkhau=$('#dn_matkhau').val();

                        loi=0;
                        if(dn_tendangnhap=="" || dn_matkhau=="")
                        {
                            loi++;
                            $('#dn_thongbao').text("Hãy nhập đầy đủ thông tin");
                        }

                        if(loi!=0)
                        {
                            return false;
                        }
                    });
                });
            </script>
        </div>
    </div>
</div>
<!--bottom-header-->
<?php
    $trang=0;
    if(isset($_GET["trang"]))
        $trang=$_GET["trang"];

    $laysp=phan_trang("*","sanpham","",6,$trang,"");

    $truyvan_laysp=$laysp;

?>

	<!--start-breadcrumbs-->
	<div class="breadcrumbs">
		<div class="container">
			<div class="breadcrumbs-main">
				<ol class="breadcrumb">
					<li><a href="../index.php">Trang Chủ</a></li>
					<li class="active">Sản phẩm</li>
				</ol>
			</div>
		</div>
	</div>
	<!--end-breadcrumbs-->
	<!--start-product--> 
	<div class="product">
		<div class="container"
			<div class="product-main">
                <!--  phan danh sach san pham -->

                <div class="col-md-9 p-left">
                    <div class="clearfix"> </div>
                    <?php
                        $i=0;
                        while($cot=mysqli_fetch_array($truyvan_laysp))
                        {
                            $i++;
                    ?>

				    <div class="product-one ">
                        <div class="col-md-4 product-left single-left">
                            <div class="p-one simpleCart_shelfItem">

                                <a href="ChiTietSanPham.php?MaSP=<?php echo $cot["MaSanPham"]; ?>" >  <!-- link chi tiet san pham -->

                                    <img height="250" src="../images/HinhSP/<?php echo $cot["Anh"] ?>" alt="" />
                                    <div class="mask mask1">
                                        <span>Xem chi tiết</span>
                                    </div>
                                </a>
                                <h4><?php echo $cot["TenSanPham"] ?></h4>
                                <div class="hot-deal-price">
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>
                                    <i class="fa fa-star" aria-hidden="true"></i>

                                    <p><s>500.00 VND</s> </p>
                                </div>
                                <p><a class="item_add" href="#"><i></i> <span class=" item_price"> <?php echo DinhDangTien($cot["DonGia"]); ?> VNĐ</span></a></p>
                            </div>
                        </div>

                    </div>



                    <?php if($i%3==0) {?>

                    <div class="clearfix"> </div>

                    <?php
                            }
                        }
                    ?>
                        <div class="divtrang"></div>
			    </div>

                <!-- phan danh muc -->
                <div class="col-md-3 p-right single-right">
                    <h3>Danh Mục</h3>

                    <ul class="product-categories">

                        <?php
                        $layLoaiSP="SELECT * FROM loaisp";
                        $truyvan_layLoaiSP=mysqli_query($GLOBALS['connect'], $layLoaiSP);
                        while($cot=mysqli_fetch_array($truyvan_layLoaiSP))
                        {
                            ?>
                            <li><a href="DanhMucSanPham.php?loaisp=<?php echo $cot["MaLoaiSP"] ?>"><?php echo $cot["TenLoai"] ?></a></li>
                        <?php
                        }
                        ?>
                    </ul>
                    <h3>Giá</h3>
                    <ul class="product-categories p1">
                        <li><a href="DanhMucSanPham.php?gia=200000">Dưới 200.000</a></li>
                        <li><a href="DanhMucSanPham.php?gia=300000">Dưới 300.000</a></li>
                        <li><a href="DanhMucSanPham.php?gia=400000">Dưới 400.000</a></li>
                        <li><a href="DanhMucSanPham.php?gia=500000">Dưới 500.000</a></li>
                    </ul>
                </div>
			<div class="clearfix"> </div>
		</div>
	</div>

	<!--end-product-->
<script>
    $(document).ready(function(){
        <?php
           echo  "$('.divtrang_".$trang."').addClass('divtrangactive')";
        ?>
    });
</script>

<?php
include("../layout/footer.php");
?>

