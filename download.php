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
        error_reporting(0); // tắt hiện lỗi =)) 
        $key = "";
        $page = 1;
        if (!is_null($_GET["key"]) && !empty($_GET["key"])) {
            $key = $_GET["key"];
            // if (!is_null($_GET["page"]) && !empty($_GET["page"])) {
            //     $page = $_GET["page"];
            // }
        } else {
            header("Location: ./index.html");
            die();
        }
        ?>
        <!-- Kết thúc phần lấy keywords -->

        <!-- Phần chèn giá trị nếu có vào form search -->
        <form class="form-inline my-2 my-lg-0 ml-auto" action="./download.php" method="get">
            <input class="form-control" type="search" placeholder="Link bài hát" aria-label="Link bài hát" value="<?php echo $key ?>" name="key">
            <button class="btn btn-danger">Tìm kiếm</button>
        </form>
        <!-- Kết thúc phần chèn giá trị vào form search -->
    </nav>
    <!-- Khu lấy danh sách các bài hát -->
    <?php
    $resultKey = $key;
    $str = "";
    if (!empty($key)) {
        $str = file_get_contents("https://www.nhaccuatui.com/tim-kiem/bai-hat?q=" . urlencode($key) . "&b=keyword&l=tat-ca&s=default&page=1");
        $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
        $str = trim(preg_replace('/\n+/', ' ', $str)); // supports line breaks
        // if (preg_match("/<span>(\(Có [0-9,]+ kết quả\))<\/span>/i", $str, $count)) // ignore case
        // {
        //     $resultKey = $resultKey . " " . $count[1];
        // }
    }
    ?>

    <div>
        <!--Body-->
        <div id="small-info"> Kết quả cho: <?php echo $resultKey ?></div>

        <table class="table table-bordered table-danger">
            <thead class="table-dark">
                <tr>
                    <th>STT</th>
                    <th>Ảnh</th>
                    <th>Tên ca sĩ</th>
                    <th>Tên bài hát</th>
                    <th>Chia sẻ</th>
                    <th>Tải xuống</th>
                </tr>
            </thead>
            <tbody>
                <!-- Khu lấy danh sách các bài hát -->
                <?php
                $stt = 1;
                $gottedLinks = [];
                if (!empty($str)) {
                    if (preg_match_all("/<li class=\"sn_search_single_song\">.*?<\/li>/m", $str, $matches, PREG_SET_ORDER, 0)) {
                        foreach ($matches as $li) {
                            $link = "";
                            if (preg_match("/href=\"(.*?)\"/i", $li[0], $got)) {
                                $link = $got[1];
                            }
                            $title = "";
                            if (preg_match("/title=\"(.+?)\"/i", $li[0], $got)) {
                                $title = $got[1];
                            }
                            $singer = "";
                            if (preg_match("/<h4 class=\"singer_song\">(.*)<\/h4>/i", $li[0], $got)) {
                                $singer = $got[1];
                                $singer = preg_replace("/<a.+?>|<\/a>/", '', $singer);
                            }
                            $img = "";
                            $mp3 = "";
                            // Lấy thực tế
                            $str = file_get_contents($link);
                            $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
                            if (preg_match("/(https:\/\/www\.nhaccuatui\.com\/flash\/xml\?html5=true&key1=.*?)\";/i", $str, $got)) {
                                $str = file_get_contents($got[1]);
                                $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
                                //                                echo "<input type=\"text\" value=\"".$str."\"/>";
                                if (preg_match("/<location>.?<!\[CDATA\[(.*?)]]>.?<\/location>.*<avatar>.?<!\[CDATA\[(.*?)]]>.?<\/avatar>/i", $str, $got)) {
                                    if (!is_null($got[1]) && !empty($got[1]))
                                        $mp3 = $got[1];
                                    if (!is_null($got[2]) && !empty($got[2]))
                                        $img = $got[2];
                                    else
                                        $img = "./img/me.png"; // Ảnh của NGHĨA >>>>>>>>>>>>>>>>>>>>>>>>>>>>
                                } else { }
                            }

                            // Combine data
                            if (!empty($title) && !empty($singer) && !empty($img) && !empty($mp3) && !in_array($link, $gottedLinks)) {
                                echo "<tr>";
                                echo "<td>" . $stt++ . "</td>";
                                echo "<td> <img class=\"imagesong\" src=" . $img . ">";
                                echo "</td>";
                                echo "<td class=\"font-center\">" . $singer . "</td>";
                                echo "<td>" . $title . "</td>";
                                echo "<td> <a class=\"btn btn-lg px-3 btn-info\" href=\"#\" role=\"button\">Chia sẻ <img src=\"./images/share.png\" height=\"30\" alt=\"share button\"></a>";
                                echo "</td>";
                                echo "<td> <a class=\"btn btn-lg px-3 btn-info\" href=" . $mp3 . " role=\"button\">Download <img src=\"./images/download-arrow.png\" height=\"30\" alt=\"share button\"></a>";
                                echo "</td>";
                                echo "</tr>";
                                array_push($gottedLinks, $link);
                            }
                        }
                    }
                }
                ?>
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