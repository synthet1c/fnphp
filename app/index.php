<?php
error_reporting(E_ALL);
ini_set('error_reporting', E_ALL);

require 'functions/utils.php';
require 'functions/f.php';
require 'functions/list.php';
require 'objects/Identity.php';
require 'objects/Constant.php';
require 'functions/functions.php';

//f::define('setTax', curry(function($tax, $product) {
//  $price = $product['price'];
//  $temp = f::compose(
//    f::set('gst', f::tax($tax, $price)),
//    f::set('exTax', f::price($tax, $price))
//  );
//  return $temp($product);
//}));

f::define('inc', f::add(1));
f::define('dec', f::subtract(1));

f::define('setPrice', function($tax, $product) {
  $product['test'] = $product['price'] * $tax;
  return $product;
});

f::define('doStuff', f::compose(
  f::trace('stuff'),
  f::over(f::lensProp('user'), f::over(f::lensProp('email'), f::upperCase())),
  f::over(f::lensProp('products'), f::map(
    f::compose(
      f::over(f::lensProp('price'), f::inc()),
      f::over(f::lensProp('name'), f::upperCase()),
      f::setPrice(0.11)
    )
  ))
  // f::over(
  //  :lensProp('id'), f::inc()
  // ),
  // f::over:lensProp('id'), f::multiply(0.11)),
  // f::over:lensProp('products'), f::map(
  //   f::compose(
  //     f::over:lensProp('name'), f::capitalize())
  //   )
  // ))
));

//f::define('decrementQuantity', f::over(
//  f::lensProp('products'),
//  f::map(f::inc())
//));
//
//f::define('incrementQuantity', f::over(
//  f::lensProp('products'),
//  f::map(f::dec())
//));

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

$people = [
  ['name' => 'simo', 'age' => 33],
  ['name' => 'chris', 'age' => 30],
  ['name' => 'foonta', 'age' => 32],
  ['name' => 'jimbo', 'age' => 33],
];

f::define('byAge', f::descend(f::prop('age')));

var_dump(
  f::sort(f::descend(f::prop('age')), $people)
);

var_dump(f::prop('name', ['name' => 'andrew']));
var_dump(f::assoc('test', 'test', ['name' => 'andrew']));

f::define('upsydownsy', f::compose(
  f::over(f::lensPath(['one', 'two']), f::upperCase()),
  f::over(f::lensPath(['one', 'three']), f::lowerCase())
));

var_dump(
  f::upsydownsy([
    'one' => [
      'two' => 'lowercase',
      'three' => 'UPPERCASE'
    ],
    'two' => 'three'
  ])
);

var_dump(
  f::view(f::lensProp('one'), ['one' => ['two' => 2]])
);

var_dump(
  f::dropWhile(function($x) { return $x <= 2; }, [1, 2, 3, 4, 3, 2, 1])
);

f::define('toObject', function($arr) {
  return (object)$arr;
});

f::define('idTimesTwo', f::compose(
  f::toObject(),
  f::over(f::lensProp('id'), f::multiply(2))
));

var_dump(
  f::idTimesTwo(['id' => 3])
);