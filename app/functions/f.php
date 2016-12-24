<?php

class f {
  public static $methods = [];

  public static function init($methods = []) {
    self::$methods = array_merge(self::$methods, $methods);
  }

  public static function define($name, $fn) {
    self::$methods[$name] = $fn;
  }
  public static function __callStatic($name, $args) {
    if (!isset(self::$methods[$name])) {
      throw new Exception("no function f::{$name}");
    }
    return call_user_func_array(self::$methods[$name], $args);
  }
}

// f::init($methods);
f::define('pipe', function(/*...$args*/) {
  $fns = func_get_args();
  return function($val) use ($fns) {
    return array_reduce($fns, function($acc, $fn) {
      return $fn($acc);
    }, $val);
  };
});

f::define('flip', function($fn) {
  return function(/* args */) use ($fn) {
    $args = array_reverse(func_get_args());
    return call_user_func_array($fn, $args);
  };
});

f::define('compose', f::flip(f::pipe()));

f::define('map', curry(function($fn, $functor) {
  return (is_array($functor))
    ? array_map($fn, $functor)
    : $functor->map($fn);
}));

f::define('add', curry(function($a, $b) {
  return $a + $b;
}));

f::define('multiply', curry(function($first, $second) {
  return $first * $second;
}));

f::define('concat', curry(function($b, $a) {
  if (is_string($b)) {
    return $a . $b;
  }
  else if (is_array($a)) {
    return array_merge($a, $b);
  }
  else if (is_object($b)) {
    return $a->concat($b);
  }
}));

f::define('prepend', curry(function($first, $second) {
  return f::concat($first, $second);
}));

f::define('append', curry(function($first, $second) {
  return f::concat($second, $first);
}));
