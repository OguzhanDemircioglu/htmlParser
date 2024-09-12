<?php
$html_content = file_get_contents('example.html');

preg_match('/<div>(.*?)<\/div>/s', $html_content, $div_content);

preg_match('/<([a-z1-6]+)>(.*?)<\/\1>/s', $div_content[1], $tag_content);

if (!empty($tag_content)) {
  $tag_name = $tag_content[1]; 
  $tag_text = $tag_content[2]; 

  $key_value_pairs["baslik"] = $tag_text;

  $div_content_without_tag = preg_replace('/<' . $tag_name . '>(.*?)<\/' . $tag_name . '>/s', '', $div_content[1]);
} else {
  $div_content_without_tag = $div_content[1]; 
}

$lines = explode('<br>', $div_content_without_tag);

foreach ($lines as $line) {
  
  $parts = explode(':', $line, 2);

  if (count($parts) == 2) {
    $key = trim(strip_tags($parts[0])); 
    $value = trim(strip_tags($parts[1]));

    if ($key === "Değerlendirme") {
      $numbers = explode(' ', $value);
      if (count($numbers) == 2) {
        $key_value_pairs[$key . " 1"] = trim($numbers[0]);
        $key_value_pairs[$key . " 2"] = trim($numbers[1]);
      }
    } else {
      $key_value_pairs[$key] = $value;
    }
  }
}

echo "<pre>";
print_r($key_value_pairs);
echo "</pre>";
?>
