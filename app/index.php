<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

require 'functions/utils.php';
require 'functions/f.php';

require 'functions/functions.php';

require 'objects/Identity.php';

$nameLens = lens('name');

f::define('setTax', curry(function($tax, $product) {
  $price = $product['price'];
  return f::compose(
    f::set('gst', f::tax($tax, $price)),
    f::set('exTax', f::price($tax, $price))
  )($product);
}));

f::define('doStuff', f::compose(
  f::json('thing'),
  f::over(
    lens('id'), f::json('id')
  )
  // f::over(lens('id'), f::multiply(0.11))
  // f::over(lens('products'), f::map(
  //   f::compose(
  //     f::over(lens('name'), f::capitalize())
  //   )
  // ))
));

f::define('inc', f::add(1));
f::define('dec', f::subtract(1));

f::define('decrementQuantity', f::over(
  lens('products'),
  f::map(f::inc())
));

f::define('incrementQuantity', f::over(
  lens('products'),
  f::map(f::dec())
));

$cart = [
  'id' => 1,
  'user' => [
    'name' => 'Andrew',
    'email' => 'founts24@gmail.com',
  ],
  'products' => [
    [
      'id' => 1,
      'name' => 'The first item',
      'price' => 69
    ],
    [
      'id' => 2,
      'name' => 'The second item',
      'price' => 79
    ],
    [
      'id' => 3,
      'name' => 'The third item',
      'price' => 99
    ],
  ],
];

f::doStuff($cart);
