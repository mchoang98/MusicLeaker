    <!-- Kết thúc lấy danh sách các bài hát-->

    Khu vực get info bài hát
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
        $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks
        if (preg_match("/<a target=.+href=\"{0,1}(.*)\"{0,1}?>.+?<\/a>/i", $str, $link)) // ignore case
        {
            $songLink = $link[1];
        } else { }
    }
    ?>
    <!-- Kết thúc phần leak nhạc -->
