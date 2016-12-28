<?php

f::define('adjust', function($fn, $index, $list) {
  $list[$index] = $fn($list[$index]);
  return $list;
});


f::define('all', function($predicate, $list) {
  $ii = count($list);
  while ($ii) {
    if (!$predicate($list[$ii])) {
      return false;
    }
    $ii--;
  }
  return true;
});

f::define('allPass', function() {

});


f::define('always', function($val) {
  return function() use ($val) {
    return $val;
  };
});


f::define('and', function($a, $b) {
  return $a && $b;
});


f::define('any', function($predicate, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if ($predicate($list[$ii])) {
      return true;
    }
    $ii++;
  }
  return false;
});

f::define('anyPass', function() {
  throw new Exception('need to define anyPass');
});


f::define('ap', function($applicative, $fn) {
  if (method_exists($applicative, 'ap')) {
    return $applicative::ap($fn);
  }
  else if (is_callable($applicative)) {
    return function($x) use ($applicative, $fn) {
      $temp = $applicative($x);
      return $temp($fn($x));
    };
  }
  else {
    return f::reduce(function($acc, $f) use ($fn) {
      return f::concat($acc, f::map($f, $fn));
    }, [], $applicative);
  }
});


f::define('aperture', function($length, $list) {
  $ret = [];
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    array_push($ret, array_slice($list, $ii, $length));
    $ii = $ii + $length;
  }
  return $ret;
});

f::define('append', function($a, $list) {
  array_push($list, $a);
  return $list;
});

f::define('apply', function($fn, $list) {
  return call_user_func_array($fn, $list);
});

f::define('applySpec', function() {
  throw new Exception('need to define applySpec');
});

f::define('assoc', function($prop, $val, $obj) {
  if (is_object($obj)) {
    $obj->$prop = $val;
  }
  else {
    $obj[$prop] = $val;
  }
  return $obj;
});

f::define('assocPath', function() {
  throw new Exception('need to define assocPath');
});

f::define('arity', function($length, $fn /*, ...$args*/) {
  $args = array_slice(func_get_args(), $length);
  return call_user_func_array($fn, $args);
});

f::define('binary', f::arity(2));

f::define('contains', function($x, $xs) {
  return in_array($x, $xs);
});

f::define('drop', function($count, $list) {
  array_splice($list, $count - 1, 1);
  return $list;
});

f::define('dropLast', function($arr) {
  return f::drop(count($arr), $arr);
});

f::define('dropLastWhile', function($predicate, $list) {
  $ii = count($list) - 1;
  while ($ii) {
    if (!$predicate($list[$ii])) {
      break;
    }
    $ii -= 1;
  }
  return array_slice($list, 0, $ii + 1);
});

f::define('dropWhile', function($predicate, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if (!$predicate($list[$ii])) {
      break;
    }
    $ii += 1;
  }
  return array_slice($list, $ii);
});

f::define('filter', f::flip('array_filter'));

f::define('find', function($predicate, $list) {
  return $list[f::findIndex($predicate, $list)];
});

f::define('findIndex', function($predicate, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if (!$predicate($list[$ii])) {
      break;
    }
    $ii += 1;
  }
  return $ii;
});

f::define('findLast', function($predicate, $list) {
  return $list[f::findLastIndex($predicate, $list)];
});

f::define('findLastIndex', function($predicate, $list) {
  $ii = count($list) - 1;
  while ($ii) {
    if ($predicate($list[$ii])) {
      break;
    }
    $ii += 1;
  }
  return $ii;
});


f::define('flatten', function() {
  throw new Exception('need to define flatten');
});


f::define('forEach', function($fn, $list) {
  forEach ($list as $value) {
    $fn($list($value));
  }
  return $list;
});


f::define('fromPairs', function($pairs) {
  $ret = [];
  forEach ($pairs as $pair) {
    $ret[$pair[0]] = $pair[1];
  }
  return $ret;
});


f::define('groupBy', function($fn, $list) {
  $ret = [];
  forEach($list as $key => $item) {
    $group = $fn($item);
    $ret[$group][]= $item;
  }
  return $ret;
});


f::define('groupWith', function($fn, $list) {
  $ret = [];
  $ii = 0;
  $ll = count($list);
  while($ii < $ll) {
    $nn = $ii + 1;
    while ($nn < $ll && $fn($list[$ii], $list[$nn])) {
      $nn += 1;
    }
    $ret[]= array_slice($list, $ii, $nn - $ii);
    $ii = $nn;
  }
  return $ret;
});

f::define('head', function($list) {
  return $list[0];
});

/**
 * @method f::reduce()
 * @example f::reduce(function($acc, $x){ return $x}, [])([0, 1, 2])
 * @sig ((a -> b) -> a) -> a -> [b] -> a
 */
f::define('reduce', curryN(1, function($fn, $init = [], $arr = null) {
  $reduce = curry(function($fn, $init, $arr) {
    return array_reduce($arr, $fn, $init);
  });
  return ($arr === null)
    ? $reduce($fn, $init)
    : $reduce($fn, $init, $arr);
}));

f::define('reduceRight', function($fn, $list) {
  $ii = count($list) - 1;
  while ($ii) {
    $acc = $fn($list[$ii], $acc);
    $ii -= 1;
  }
  return $acc;
});