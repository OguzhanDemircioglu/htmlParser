<?php
include('rapor.php');

class newParserHtml{
  
  public function __construct()
  {
  }

  function getRapor($studies){
    foreach ($studies as $study) {
      $key_value_pairs = [];
      if (isset($study["rapor"])) {

        preg_match_all('/<div>(.*?)<\/div>/', $study["rapor"], $matches);

        $lines = $matches[1];

        $yeni_rapor = preg_replace('/<div>(.*?)<\/div>/', '', $study["rapor"]);
        $study["rapor"] = $yeni_rapor;

        $key_value_pairs['Başlık'] = "";

        for ($i = 0; $i < count($lines); $i++) {

          if (!str_contains($key_value_pairs['Başlık'], 'HastaAdı')) {

            if (str_contains($lines[$i], "ID") && str_contains($lines[$i], "AcN")) {
              $string = trim(strip_tags($lines[$i]));
              $pairs = explode(' ', $string);
              $key_value_pairs['Başlık'] .= " ID: $pairs[2]" . " AcN: " . $pairs[count($pairs) - 1];

            } else {
              $parts = explode(':', $lines[$i]);
              $key = preg_replace('/\s+/', '', trim(strip_tags($parts[0])));
              $value = trim(strip_tags($parts[1]));

              if (!str_contains($key_value_pairs['Başlık'], $key)) {
                $key_value_pairs['Başlık'] .= " " . $key . ":" . $value;


              }
            }
          }
        }

        if (str_contains($study["rapor"], "İnceleme tekniği:")) {

          $baslangic = strpos($study["rapor"], "İnceleme tekniği:") + strlen("İnceleme tekniği:");
          $son = strpos($study["rapor"], "Bulgular:");
          $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);

          $key = "İnceleme tekniği";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }

        if (str_contains($study["rapor"], "Karşılaştırma :")) {

          $baslangic = strpos($study["rapor"], "Karşılaştırma :") + strlen("Karşılaştırma :");
          $son = strpos($study["rapor"], "Bulgular");
          $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);


          $key = "Karşılaştırma";
          $value = preg_replace('/\s+/', '', trim(strip_tags($arananDeger)));
          if ($value !== "" && $value !== "&nbsp;") {
            $key_value_pairs[$key] = $value;
          }

        }

        if (str_contains($study["rapor"], "Bulgular")) {

          $baslangic = strpos($study["rapor"], "Bulgular:") + strlen("Bulgular:");
          $sonSonuc = strpos($study["rapor"], "Değerlendirme:");
          $arananSonuc = "";

          if (str_contains($study["rapor"], "SONU&Ccedil;")) {
            $son = strpos($study["rapor"], "SONU&Ccedil;");
            $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);

            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);

          } else if (str_contains($study["rapor"], "Sonuç:&nbsp;")) {
            $son = strpos($study["rapor"], "Sonuç:&nbsp;");
            $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);

            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);
          } else if (str_contains($study["rapor"], "Sonuç:")) {
            $son = strpos($study["rapor"], "Sonuç:");
            $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);
            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);
          } else if (str_contains($study["rapor"], "Sonu&ccedil;")) {
            $son = strpos($study["rapor"], "Sonu&ccedil;");
            $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);
            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);
          } else if (str_contains($study["rapor"], "SONUÇ : ")) {
            $son = strpos($study["rapor"], "SONUÇ : ");
            $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);
            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);
          } else {
            $arananDeger = substr($study["rapor"], $baslangic);
            $arananSonuc = substr($study["rapor"], $son, $sonSonuc - $son);
          }

          $arananSonuc = preg_replace('/^Sonuç:\s*/', '', $arananSonuc);
          $arananSonuc = preg_replace('/^SONUÇ:\s*/', '', $arananSonuc);
          $key_value_pairs['Sonuç'] = trim($arananSonuc);

          $key = "Bulgular";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }

        if (str_contains($study["rapor"], "Değerlendirme:")) {

          $study["rapor"] = preg_replace('/\r|\n/', '', $study["rapor"]);
          $baslangic = strpos($study["rapor"], "Değerlendirme:") + strlen("Değerlendirme:");
          $son = strpos($study["rapor"], "İmza:");
          $arananDeger = substr($study["rapor"], $baslangic, $son - $baslangic);

          $key = "Değerlendirme";
          $value = trim($arananDeger);
          $value = preg_replace('/\s+/', '', trim(strip_tags($arananDeger)));
          if ($value !== "" && $value !== "&nbsp;") {
            $key_value_pairs[$key] = $value;
          }

        }

        if (str_contains($study["rapor"], "İmza:")) {

          $baslangic = strpos($study["rapor"], "İmza:") + strlen("İmza:");
          $son = strpos($study["rapor"], "İmza:");
          $arananDeger = substr($study["rapor"], $baslangic);

          $key = "İmza";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }
      }
      echo "<pre>";
      print_r($key_value_pairs);
      echo "</pre>";
    }


  }
}

?>

