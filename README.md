# Scraper emergencies firefighters with PHP

All the data is scraped from http://bomberosperu.gob.pe/po_diario.asp

## How to use

```php
 // You must have simple_html_dom.php
 include('simple_html_dom.php');

// Get DOM
 $html = file_get_html('http://bomberosperu.gob.pe/po_diario.asp');

 foreach($html->find('tr') as $div) {
   echo "Nro. Parte: ".$div->find('td.lineaizq', 1)->plaintext;
 }
```