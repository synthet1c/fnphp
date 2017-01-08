<?php

require 'all.php';
require 'any.php';
require 'ap.php';
require 'ascend.php';
require 'descend.php';
require 'lens.php';
require 'prop.php';
require 'sort.php';


f::define('always', function($val) {
  return function() use ($val) {
    return $val;
  };
});

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

f::define('diff', function($a, $b) {
  if (is_string($a) && is_string($b)) {
    return ord($a) - ord($b);
  }
  return $a - $b;
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

f::define('sum', f::reduce(f::add(), 0));

f::define('subtract', function($first, $second) {
  return $first - $second;
});

f::define('multiply', function($first, $second) {
  return $first * $second;
});

f::define('concat', function($first, $second) {
  if (is_string($first) && is_string($second)) {
    return $first . $second;
  }
  if (is_array($first) && is_array($second)) {
    return array_merge($first, $second);
  }
  else {
    return array_merge($second, [$first]);
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

f::define('split', function($pattern, $str) {
  if ($pattern === '') {
    return str_split($str);
  }
  return preg_split($pattern, $str);
});

f::define('join', function($separator, $arr) {
  return implode($separator, $arr);
});

f::define('trace', function($name, $arr) {
  echo 'trace: ' . $name . PHP_EOL;
  var_dump($arr, true);
  return $arr;
});

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

f::define('mjoin', function($monad) {
  return $monad->join();
});