<?php
include('rapor.php');

$key_value_pairs = [];

foreach ($studies as $study) {

  if (isset($study["rapor"])) {
    $lines = explode('</div>', $study["rapor"]);
    $key_value_pairs['Başlık'] = "";
    
    for ($i = 0; $i < count($lines); $i++) {

      if (!str_contains($key_value_pairs['Başlık'], 'HastaAdı')) {

        if (str_contains($lines[$i], "ID")) {
          $string = trim(strip_tags($lines[$i]));

          $pairs = explode(' ', $string);

       /*   $key_value_pairs['ID'] = $pairs[2];
          $key_value_pairs['AcN'] = $pairs[count($pairs) - 1];*/

          $key_value_pairs['Başlık'] .=" ID: $pairs[2]" . " AcN: " . $pairs[count($pairs) - 1];

        } else {
          $parts = explode(':', $lines[$i]);
          $key = preg_replace('/\s+/', '', trim(strip_tags($parts[0])));
          $value = trim(strip_tags($parts[1]));
          /*$key_value_pairs[$key] = $value;*/
          
          if (!str_contains($key_value_pairs['Başlık'], $key)) {
            $key_value_pairs['Başlık'] .= " ". $key . ":" . $value;
          }
         
        }

      } else {

        if (str_contains($lines[$i], "İnceleme tekniği:")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "İnceleme tekniği:") + strlen("İnceleme tekniği:");
          $son = strpos($lines[$i], "Bulgular");
          $arananDeger = substr($lines[$i], $baslangic);

          $key = "İnceleme tekniği";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }
        
        if (str_contains($lines[$i], "Karşılaştırma :")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "Karşılaştırma :") + strlen("Karşılaştırma :");
          $son = strpos($lines[$i], "Bulgular");
          $arananDeger = substr($lines[$i], $baslangic);

          
          $key = "Karşılaştırma";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }
        
        if (str_contains($lines[$i], "Bulgular:")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "Bulgular:") + strlen("Bulgular:");
          
          if (str_contains($lines[$i], "SONU&Ccedil;:")) {
            $son = strpos($lines[$i], "SONU&Ccedil;:");
            $arananDeger = substr($lines[$i], $baslangic, $son - $baslangic);
          } else if (str_contains($lines[$i], "Sonuç:&nbsp;")) {
            $son = strpos($lines[$i], "Sonuç");
            $arananDeger = substr($lines[$i], $baslangic, $son - $baslangic);
          } else if (str_contains($lines[$i], "SONUÇ : ")) {
            $son = strpos($lines[$i], "SONUÇ : ");
            $arananDeger = substr($lines[$i], $baslangic, $son - $baslangic);
          } else {
            $arananDeger = substr($lines[$i], $baslangic);
          }

          $key = "Bulgular";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }        
        
        if (str_contains($lines[$i], "SONU&Ccedil;:")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "Sonu&ccedil;:&nbsp;") + strlen("Sonu&ccedil;:&nbsp;");
          $son = strpos($lines[$i], "Değerlendirme:");
          $arananDeger = substr($lines[$i], $baslangic, $son - $baslangic);

          $key = "Sonuç";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }

        if (str_contains($lines[$i], "Değerlendirme:")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "Değerlendirme:") + strlen("Değerlendirme:");
          $son = strpos($lines[$i], "İmza:");
          $arananDeger = substr($lines[$i], $baslangic, $son - $baslangic);

            $key = "Değerlendirme";
            $value = trim($arananDeger);
            $key_value_pairs[$key] = $value;

        }
        if (str_contains($lines[$i], "İmza:")) {

          /*$lines[$i] = preg_replace('/\r|\n/', '', $lines[$i]);*/
          $baslangic = strpos($lines[$i], "İmza:");
          $son = strpos($lines[$i], "İmza:");
          $arananDeger = substr($lines[$i], $baslangic);

          $key = "İmza";
          $value = trim($arananDeger);
          $key_value_pairs[$key] = $value;
        }
        

      }
    }
  }
  echo "<pre>";
  print_r($key_value_pairs);
  echo "</pre>";
}

