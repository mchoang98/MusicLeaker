# Music Leaker - ỨNG DỤNG WEB TÌM KIẾM ÂM NHẠC MIỄN PHÍ - FREE FINDING SONG INTERNET
## Cảm ơn đã ghé thăm, website vẫn chưa hoàn thiện, rất mong có sự giúp sức !

#  Chức năng của Music Leaker
- Tìm kiếm bài hát yêu thích.
- Nghe và tải nhạc miễn phí.
- Đăng nhập và đăng ký tài khoản.
- Share địa chỉ nghe và tải nhạc đến các mạng XH.


## Ngôn ngữ chính PHP, HTML, Javascripts, Bootstrap 4  ##

[![vqyDqU.png](https://b.imge.to/2019/09/29/vqyDqU.png)](https://imge.to/i/vqyDqU)





# Dữ liệu vào (Input data) 
## Nếu có thể hãy giúp chúng tôi hoàn thiện những tính năng *chưa hoàn thiện* bên dưới :point_down:
- Tên bài hát, tên ca sĩ, tên album
- (**chưa hoàn thiện**) Link Address 
- (**chưa hoàn thiện**) youtube link Address !
# Dữ liệu ra (Output data)
- Tên bài hát hoặc ca sĩ
- Bản nghe thử (**chưa hoàn thiện**)
- Link download 
- Share tới mạng xã hội (**chưa hoàn thiện**)

# Trang chủ (Index)

[![vqyDqU.png](https://b.imge.to/2019/09/29/vqyDqU.png)](https://imge.to/i/vqyDqU)

# Trang tải (Download)

[![vZlfZV.md.png](https://a.imge.to/2019/11/25/vZlfZV.md.png)](https://imge.to/i/vZlfZV)

# Trang đăng ký (Register)
[![vqye9H.png](https://a.imge.to/2019/09/29/vqye9H.png)](https://imge.to/i/vqye9H)

# Hàm (Function)

## *Chúng tôi viết các hàm này bên trong một class và gọi ra khi cần* 
## *Các bạn có thể xem thêm ở file GetObject.php bên trên* 

 ## Hàm getKeyWord()
- Input keyword
- Output key no error
 
 function getKeyWord()
   { 
   
    error_reporting(0); // tắt hiện lỗi =)) 
    if (!is_null($_GET["key"]) && !empty($_GET["key"])) {
        $this->key = $_GET["key"];
        // if (!is_null($_GET["page"]) && !empty($_GET["page"])) {
        //     $this->page = $_GET["page"];
        // }
    } else {
        header("Location: ./index.html");
        die();
    }
    
   }
   
  ## Hàm getSongName()
  - Input keyword
  - Output In ra kết quả
  
  function getSongName()
   {
   
    $resultKey = $th->key;

    echo $resultKey;
   }

 ## Hàm getDetailSong()
 - Input : keyword
 - Output : các value bài hát hiển thị ngay dưới danh sách theo đúng thứ tự, có đánh số, đồng thời chứa link và trình nghe nhạc khi bấm các buttton 
 
 function getDetailSong()
   {
   
    $stt = 1;
    $gottedLinks = [];
    if (!empty($this->str)) {
        if (preg_match_all("/<li class=\"sn_search_single_song\">.*?<\/li>/m", $this->str, $matches, PREG_SET_ORDER, 0)) {
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
                $this->str = file_get_contents($link);
                $this->str = trim(preg_replace('/\s+/', ' ', $this->str)); // supports line breaks
                if (preg_match("/(https:\/\/www\.nhaccuatui\.com\/flash\/xml\?html5=true&key1=.*?)\";/i", $this->str, $got)) {
                    $this->str = file_get_contents($got[1]);
                    $this->str = trim(preg_replace('/\s+/', ' ', $this->str)); // supports line breaks
                    //                                echo "<input type=\"text\" value=\"".$this->str."\"/>";
                    if (preg_match("/<location>.?<!\[CDATA\[(.*?)]]>.?<\/location>.*<avatar>.?<!\[CDATA\[(.*?)]]>.?<\/avatar>/i", $this->str, $got)) {
                        if (!is_null($got[1]) && !empty($got[1]))
                            $mp3 = $got[1];
                        if (!is_null($got[2]) && !empty($got[2]))
                            $img = $got[2];
                        else
                            $img = "./img/me.png"; // Ảnh của NGHĨA >>>>>>>>>>>>>>>>>>>>>>>>>>>>
                            
                            
  ## Tác giả: 
- **Nguyễn Trọng Nghĩa** - Back End Developer (PHP, MySQL) - **[link to GitHub!](https://github.com/futureskyprojects)
- **Hoàng Thiên Phú** - Front End Developper (HTML, CSS, Javascripts, Bootstrap 4, Git Manager) - **[link to GitHub!](https://github.com/mchoang98)
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
                    echo "<td> <a class=\"btn btn-lg px-3 btn-info\" href=\"#\" role=\"button\">Nghe  <img src=\"./images/play.png\" height=\"30\" alt=\"share button\"></a>";
                    echo "</td>";
                    echo "<td> <a class=\"btn btn-lg px-3 btn-info\" href=" . $mp3 . " role=\"button\">Download <img src=\"./images/download-arrow.png\" height=\"30\" alt=\"share button\"></a>";
                    echo "</td>";
                    echo "</tr>";
                    array_push($gottedLinks, $link);
                }
            }
        }
    }
    
   }
   
   
   
   
   
   
