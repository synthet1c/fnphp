<?php

require 'all.php';
require 'any.php';
require 'ap.php';
require 'ascend.php';
require 'descend.php';
require 'lens.php';
require 'prop.php';
require 'sort.php';

f::define('identity', function($x) {
  return $x;
});

f::define('set', function($prop, $value, $obj) {
  $obj[$prop] = $value;
  return $obj;
});

f::define('tax', function($percent, $price) {
  return round($price * $percent / (100 + $percent), 2);
});

f::define('price', function($percent, $price) {
  return round($price * 100 / (100 + $percent), 2);
});

f::define('capitalize', function($str) {
  return ucwords($str);
});

f::define('add', function($first, $second) {
  if (is_string($first)) {
    return $first . $second;
  }
  if (is_array($first)) {
    return array_map(f::add($second), $first);
  }
  return $first + $second;
});

f::define('subtract', function($first, $second) {
  return $first - $second;
});

f::define('multiply', function($first, $second) {
  return $first * $second;
});

f::define('concat', function($first, $second) {
  if (is_string($first)) {
    return $first . $second;
  }
  if (is_array($first)) {
    return array_merge($first, $second);
  }
});

f::define('equals', function($a, $b) {
  return $a === $b;
});

f::define('map', function($fn, $obj) {
  if (is_array($obj)) {
    return array_map($fn, $obj);
  }
  return $obj->map($fn);
});

f::define('join', function($arr) {
  return implode(', ', $arr);
});

// f::define('over', function($lens, $fn, $arr) {
//   $prop = $lens($arr);
//   return $prop($fn);
// });

f::define('trace', function($name, $arr) {
  echo 'trace: ' . $name . PHP_EOL;
  var_dump($arr, true);
  return $arr;
});

// $_json = function($name, $arr) {
//   echo '<pre>' . json_encode($arr, 128) . '</pre>';
//   return $arr;
// });
//

// f::var('thing', f::add(1));

f::define('json', function($name, $arr) {
  return json_encode($arr);
});

f::define('lowerCase', function($str) {
  return strtolower($str);
});

f::define('upperCase', function($str) {
  return strtoupper($str);
});

f::define('reverse', function($xs) {
  if (is_string($xs)) {
    return implode('', array_reverse(str_split($xs)));
  }
  return array_reverse($xs);
});

f::define('compliment', function($f) {
  return curryN(1, function($x) use ($f) {
    return !call_user_func_array($f, func_get_args());
  });
});

f::define('isEven', function($x) {
  return $x % 2 === 0;
});

f::define('isOdd', f::compliment(f::isEven()));

f::define('test', f::add(1));
