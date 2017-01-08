<?php

f::define('allPass', function($conditions, $object) {
  forEach ($conditions as $condition) {
    if (!$condition($object)) {
      return false;
    }
  }
  return true;
});

f::define('and', function($a, $b) {
  return $a && $b;
});

f::define('anyPass', function($conditions, $object) {
  forEach ($conditions as $condition) {
    if ($condition($object)) {
      return true;
    }
  }
  return false;
});

f::define('both', function($a, $b, $value) {
  return $a($value) && $b($value);
});

f::define('cond', function() {
  throw new Exception('need to define f::cond');
});

f::define('defaultTo', function($default, $value) {
  return is_null($value)
    ? $default
    : $value;
});

f::define('either', function($a, $b, $value) {
  return $a($value) || $b($value);
});

f::define('ifElse', function($pairs) {
  $arity = f::reduce(f::max(), 0, f::map(function($pair) {
    return count($pair[0]);
  }, $pairs));
  return f::arity($arity, function(...$args) use ($pairs) {
    $ii = 0;
    $ll = count($pairs);
    while ($ii < $ll) {
      if (call_user_func_array($pairs[$ii][0], $args)) {
        return call_user_func_array($pairs[$ii][1], $args);
      }
      $ii += 1;
    }
  });
});

f::define('isEmpty', function($object) {
  return (
    (is_array($object) && count($object) === 0) ||
    (is_string($object) && $object === '')
  );
});

f::define('not', function($val) {
  return !$val;
});

f::define('or', function($a, $b) {
  return $a || $b;
});

f::define('pathSatisfies', function($fn, $path, $object) {
  return $fn(f::path($path, $object));
});

f::define('propSatisfies', function($fn, $prop, $object) {
  return $fn($object[$prop]);
});

f::define('unless', function($predicate, $whenFalseFn, $object) {
  return $predicate($object)
    ? $object
    : $whenFalseFn($object);
});

f::define('until', function($predicate, $fn, $init) {
  $val = $init;
  while (!$predicate($val)) {
    $val = $fn($val);
  }
  return $val;
});

f::define('when', function($predicate, $whenTrueFn, $x) {
  return $predicate($x) ? $whenTrueFn($x) : $x;
});

f::define('lessThan', function($a, $b) {
  return $b < $a;
});

f::define('greaterThan', function($a, $b) {
  return $b > $a;
});

f::define('lessThanEqual', function($a, $b) {
  return $b <= $a;
});

f::define('greaterThanEqual', function($a, $b) {
  return $b >= $a;
});

f::define('propSatisfies', function($fn, $prop, $object) {
  return $fn($object[$prop]);
});