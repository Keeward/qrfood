QRFood
======

QRFood allows you to create QR that contains meals nutritional informations for your menus

You may test it here: http://qr.kwrd.co/

Disclaimer
----------
This app is just a dummy test.

It is very badly coded, not enought commented, but quite straightforward.

Do not hesitate to fork, copy or contact me.

Information
-----------
QRFood stores all information into a single URL, encoded as a QRCode.

So even without a specific application, the QRCode is self-explanatory.

Because it stores a URL, special characters have been removed with Base64 encoding.

Because all the data is stored within the QR-code (QRCodes can contain up to 3KB) you don't need any internet connection.

QRFood stores these:
- meal_name (unlimited UTF-8 string),
- foursquare_id (12 bytes),
- weight (2 bytes), 
- calories (2 bytes),
- saturated_fat (2 bytes),
- unsaturated_fat (2 bytes),
- sodium (2 bytes),
- carbohydrates (2 bytes),
- fiber (2 bytes),
- sugar (2 bytes),
- protein (2 bytes),
- cholesterol (2 bytes).
 
Decoding
--------
In order to decode a QRFood, you just need to:
- get the *REQUEST_URI* (after http://qr.kwrd.com/)
- decode Base64
- the first 10 bytes are the numeric values, in this order: weight, calories, saturated_fat, unsaturated_fat, sodium, carbohydrates, fiber, sugar, protein, cholesterol
- then 12 bytes for Foursquare id
- then utf-8 meal name string

Installation
------------
- Download [PHPQRCode](http://phpqrcode.sourceforge.net/) and copy it into the QFood home directory
- Allow apache server (www-data) to write into the *phpqrcode/temp/* and *phpqrcode/cache/* directories
- Add the following to your Apache VirtualHost configuration:

```
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
```

Example
-------

[Salade saveur du Lézard Café](http://qr.kwrd.co/AZABaQADABcCJgAOAAMAAwALAFRKx1nJ+WSlIOq2IONTYWxhZGUgc2F2ZXVyIGR1IEzDqXphcmQgQ2Fmw6k=)

License
-------

The QRFood code is free to use and distribute, under the [LGPL license](https://raw.github.com/Keeward/qrfood/master/LICENSE).

QRFood uses third-party libraries:

* [PHPQRCode](http://phpqrcode.sourceforge.net/), licensed under the [LGPL License](http://www.gnu.org/licenses/lgpl.html),
* [TwitterBootstrap](http://twitter.github.com/bootstrap/), licensed under the [Apache License v2.0](http://www.apache.org/licenses/LICENSE-2.0),
