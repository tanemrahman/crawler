<?php
include_once("simple_html_dom.php");

$products = [
	['title','category','price','product_link','image_link'],
];

// create HTML DOM
$html = file_get_html('https://delisale.tanemrahman.com/shop/');

// get news block
foreach( $html->find('div.product') as $product ) {
    $item['title'] = trim($product->find('h3.wd-entities-title a', 0)->plaintext);
    $item['category'] = trim($product->find('div.wd-product-cats a', 0)->plaintext);
    $item['price'] = trim($product->find('div.wrapp-product-price span', 0)->plaintext);
    $item['product_url'] = trim($product->find('h3.wd-entities-title a', 0)->href);
    $item['image_url'] = trim($product->find('a.product-image-link img', 0)->src);
    array_push($products, $item);
}

$path = 'products.csv';

// set output headers to download file
$fp = fopen($path, 'w'); // open in write only mode (write at the start of the file)
foreach ($products as $product) {
    fputcsv($fp, $product);
}
fclose($fp);

header("Content-Description: File Transfer"); 
header("Content-Type: application/octet-stream"); 
header("Content-Disposition: attachment; filename=\"". $path . "\"");
readfile ($path);
?>
