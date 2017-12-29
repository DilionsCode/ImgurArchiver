<?php
class Scraper {
  public function __construct($from) {
    $this->from = $from;
  }

  public function getImages() {
    $data = json_decode(file_get_contents("https://imgur.com/".$this->from."/page/1.json"), true);
    foreach ($data['data'] as $d) {
      if($d['mimetype'] == "image/jpeg") {
        $fileType = ".jpg";
      } elseif($d['mimetype'] == "image/png") {
        $fileType = ".png";
      } elseif($d['mimetype'] == "image/gif") {
        continue;
      }

      $url = "https://i.imgur.com/".$d['hash']."".$fileType."";

      clearstatcache();
      $split_image = pathinfo($url);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL , $url);
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.A.B.C Safari/525.13");
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      $response= curl_exec ($ch);
      curl_close($ch);
      $parse = parse_url($url);
      $fileDir = $parse['path'];
      $file_name = "images". $fileDir;
      $file = fopen($file_name , 'w') or die("X_x");
      fwrite($file, $response);
      fclose($file);
      if(filesize($file_name) == '') {
        unlink($file_name);
      }
    }
  }


}
?>
