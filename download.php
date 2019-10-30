<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="https://fonts.googleapis.com/css?family=Pacifico&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Bangers&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./ncss/image.css">
    <link rel="stylesheet" href="./ncss/space.css">
    <link rel="stylesheet" href="./ncss/font.css">

    <title>Music Leaker</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">

    <!--Font awesome icon-->
    <link rel="stylesheet" href="./New folder/css/font-awesome.min.css">

</head>


<body>
    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container-fluid" style="
        
        margin: 0;
        width: 100%;
        padding: 0;
        background-color: #FFF;
    
    ">
            <img class="logo" src="./images/Capture.PNG">

            <div>
                <a class="btn btn-danger fas fa-home button-height" style="
        padding-top: 15px;" href="./index.html"> Trang chủ</a>
                <a class="btn btn-danger fas fa-arrow-circle-down button-height" style="
        padding-top: 15px;" href="./download.html"> Tải xuống</a>
                <a class="btn btn-danger fas fa-user button-height" style="
         padding-top: 15px;" href="./SignIn.html"> Đăng nhập</a>
                <a class="btn btn-danger fas fa-edit button-height" style="
         padding-top: 15px;" href="./Register.html"> Đăng ký</a>

            </div>


        </div>

        <!-- Lấy key words tìm kiếm được truyền vào -->
        <?php
        $key = "";
        if (!is_null($_GET["key"]) && !empty($_GET[key])) {
            $key = $_GET["key"];
        }
        ?>
        <!-- Kết thúc phần lấy keywords -->

        <!-- Phần chèn giá trị nếu có vào form search -->
        <form class="form-inline my-2 my-lg-0 ml-auto" action="./download.php" method="get">
            <input class="form-control" type="search" placeholder="Link bài hát" aria-label="Link bài hát" value=<?php echo $key ?> name="key">
            <button class="btn btn-danger">Tìm kiếm</button>
        </form>
        <!-- Kết thúc phần chèn giá trị vào form search -->
    </nav>

    <!-- Khu vực get info bài hát -->
    <?php
    if (!empty($key)) {
        $str = file_get_contents($key);
        /* Các thuộc tính cần thiết */
        $gottedResult = "";
        $songImage = "";
        $songName = "";
        $singer = "";

        /* Kết thúc các thông tin cần thiết */

        if (strlen($str) > 0) {
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
            if (preg_match("/\<title\>(.*)\<\/title\>/i", $str, $title)) // ignore case
            {
                $gottedResult = $title[1];
                $tempArr = explode(" - ", $gottedResult);
                if (count($tempArr) > 0) {
                    // Nếu có tên bài hát
                    $songName = trim(preg_replace('/\s+/', ' ', $tempArr[0]));
                }
                if (count($tempArr) > 1) {
                    // Nếu có ca sỹ
                    $singer = trim(preg_replace('/\s+/', ' ', $tempArr[1]));
                }
            } else {
                // Nếu không lấy kiểu quân tử được, chơi sang kiểu tiểu nhân
                $str = file_get_contents("https://www.google.com.vn/search?q=" . $key . "&hl=vi");
                $str = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
                    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UTF-16BE');
                }, $str);
                $subKey = preg_replace('/\//', '\/', $key);
                $subKey = preg_replace('/\./', '\.', $subKey);
                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
                if (preg_match("/<a href=\"\/url\?q=" . $subKey . ".+?><div.+?>(.*?)<\/div>/i", $str, $title)) // ignore case
                {
                    $gottedResult = $title[1];
                    $tempArr = explode(" - ", $gottedResult);
                    if (count($tempArr) > 0) {
                        // Nếu có tên bài hát
                        $songName = trim(preg_replace('/\s+/', ' ', $tempArr[0]));
                    }
                    if (count($tempArr) > 1) {
                        // Nếu có ca sỹ
                        $singer = trim(preg_replace('/\s+/', ' ', $tempArr[1]));
                    }
                }
            }
        }

        if (!empty($gottedResult)) {
            $str = file_get_contents("https://www.google.com.vn/search?q=" . urlencode($gottedResult) . "&tbm=isch&hl=vi");
            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
            if (preg_match("/<a href=\"\/url\?q=.+\"><img .+src=\"(.*)\" w.+\"><\/a>/i", $str, $image)) // ignore case
                $songImage = $image[1];
        }
    }
    ?>
    <!-- Kết thúc get info -->

    <!-- Khu vự leak nhạc -->
    <?php
    static $fixedGetLinkUrl = 'http://getlink.songhanh.com.vn/index.php?link=';
    if (!empty($key)) {
        $songLink = "";
        $str = file_get_contents($fixedGetLinkUrl . $key);
        print_r($fixedGetLinkUrl . $key);
        $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
        var_dump($songLink);
        if (preg_match("/<a target=.+href=\"(.*)\">.+<\/a>/i", $str, $link)) // ignore case
            $songLink = $link[1];
    }
    ?>
    <!-- Kết thúc phần leak nhạc -->

    <div>
        <!--Body-->
        <div id="small-info"> Kết quả cho: <?php echo $gottedResult ?></div>

        <table class="table table-bordered table-danger">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Tên ca sĩ</th>
                    <th>Tên bài hát</th>
                    <th>Chia sẻ</th>
                    <th>Tải xuống</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td> <img class="imagesong" src=<?php echo $songImage ?> />
                    </td>
                    <td class="font-center"><?php echo $singer ?></td>
                    <td><?php echo $songName ?></td>
                    <td> <a class="btn btn-lg px-3 btn-info" href="#" role="button">Chia sẻ <img src="./images/share.png" height="30" alt="share button"></a>
                    </td>

                    <td> <a class="btn btn-lg px-3 btn-info" href=<?php echo $songLink ?> role="button">Download <img src="./images/download-arrow.png" height="30" alt="share button"></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>



    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <ul class="list-inline mb-2">
                        <li class="list-inline-item">
                            <a class="font-weight-bold mb-0 " style="color:rgba(238, 220, 247, 0.849)" href="#">Chúng tôi</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a class="font-weight-bold mb-0 " style="color:rgba(238, 220, 247, 0.849)" href="#">Liên hệ</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a class="font-weight-bold mb-0 " style="color:rgba(238, 220, 247, 0.849)" href="#">Terms of Use</a>
                        </li>
                        <li class="list-inline-item">&sdot;</li>
                        <li class="list-inline-item">
                            <a class="font-weight-bold mb-0 " style="color:rgba(238, 220, 247, 0.849)" href="#">Privacy Policy</a>
                        </li>
                    </ul>
                    <p class="text-muted small mb-4 mb-lg-0">&copy; Music Leaker. All Rights Reserved.</p>
                </div>
                <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-facebook fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item mr-3">
                            <a href="#">
                                <i class="fab fa-twitter-square fa-2x fa-fw"></i>
                            </a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#">
                                <i class="fab fa-instagram fa-2x fa-fw"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>


    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>