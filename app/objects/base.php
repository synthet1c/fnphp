<?php

f::define('add1', f::add(1));

f::define('setTax', curry(function($tax, $product) {
  $price = $product['price'];
  $product['price'] = f::tax($tax, $price);
  $product['tax'] = f::tax($tax, $price);
  return $product;
}));

var_dump(
  f::compose(
    f::concat([100,200]),
    f::map(
      f::compose(
        f::add(4),
        f::add1(),
        f::multiply(3)
      )
    )
  )(f::concat([5, 6, 7], [1, 2, 3, 4]))
);

class Product {
  static function of($val) {
    return new Product($val);
  }
  public function __construct($val) {
    $this->val = $val;
  }
  public function map($fn) {
    return Product::of($fn($this->val));
  }
}

$_oMap = curry(function($fn, $obj) {
  return $obj->map($fn);
});

var_dump(
  f::map(function($val) {
    return $val * 2;
  }, Product::of(2))
);
