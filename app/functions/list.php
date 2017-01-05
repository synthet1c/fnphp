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

f::define('ap', function ($applicative, $fn) {
  if (method_exists($applicative, 'ap')) {
    return $applicative::ap($fn);
  } else if (is_callable($applicative)) {
    return function ($x) use ($applicative, $fn) {
      $temp = $applicative($x);
      return $temp($fn($x));
    };
  } else {
    return f::reduce(function ($acc, $f) use ($fn) {
      return f::concat($acc, f::map($f, $fn));
    }, [], $applicative);
  }
});


f::define('ap', function ($applicative, $fn) {
  if (method_exists($applicative, 'ap')) {
    return $applicative::ap($fn);
  } else if (is_callable($applicative)) {
    return function ($x) use ($applicative, $fn) {
      $temp = $applicative($x);
      return $temp($fn($x));
    };
  } else {
    return f::reduce(function ($acc, $f) use ($fn) {
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

f::define('indexBy', function($fn, $list) {
  throw new  Exception('need to define f::indexBy');
});

f::define('indexOf', function($x, $list) {
  return array_search($x, $list);
});

f::define('init', function($list) {
  return array_slice($list, 0, count($list) - 1);
});

f::define('insert', function($index, $item, $list) {
  array_splice($list, $index, 0, [$item]);
  return $list;
});

f::define('insertAll', function($index, $items, $list) {
  array_splice($list, $index, 0, $items);
  return $list;
});

f::define('intersperse', function($x, $xs) {
  $ret = [];
  $ii = 0;
  $ll = count($xs);
  while ($ii < $ll) {
    array_push($ret, $xs[$ii], $x);
    $ii += 1;
  }
  return $ret;
});

f::define('into', function() {
  throw new Exception('need to define f::into');
});

f::define('join', function($glue, $list) {
  return implode($glue, $list);
});

f::define('last', function($list) {
  return $list[count($list) - 1];
});

f::define('lastIndexOf', function($x, $xs) {
  return array_search($x, array_reverse($xs));
});

f::define('length', function($list) {
  return count($list);
});

f::define('mapAccum', function($fn, $acc, $list) {
  $ii = 0;
  $ll = count($list);
  $ret = [];
  $tuple = [$acc];
  while ($ii < $ll) {
    $tuple = $fn($tuple[0], $list[$ii]);
    $ret[$ii] = $tuple[1];
    $ii += 1;
  }
  return [$tuple[0], $ret];
});

f::define('mapAccumRight', function($fn, $acc, $list) {
  $ii = count($list) - 1;
  $ret = [];
  $tuple = [$acc];
  while ($ii >= 0) {
    $tuple = $fn($tuple[0], $list[$ii]);
    $ret[$ii] = $tuple[1];
    $ii -= 1;
  }
  return [$tuple[0], $ret];
});

f::define('mergeAll', function($list) {
  return array_merge(func_get_args());
});

f::define('mergeWithKey', function($fn, $list) {
  $ret = [];
  forEach($list as $key => $value) {
    if (array_search($list, $value)) {
      $ret[$value] = array_search($k, $r);
    }
  }
});

f::define('none', f::compose(f::not(),f::any()));

f::define('nth', function($ii, $xs) {
  if ($ii < 0) {
    return array_reverse($xs)[($ii * -1) - 1];
  }
  return $xs[$ii];
});

f::define('pair', function($a, $b) {
  return [$a, $b];
});

f::define('reverse', function($list) {
  return array_reverse($list);
});

f::define('range', function ($start, $end) {
  $ret = [];
  while ($start < $end) {
    $ret[] = $start;
    $start += 1;
  }
  return $ret;
});

f::define('reject', function ($pred, $filterable) {
  return f::filter(f::compliment($pred), $filterable);
});

f::define('remove', function ($start, $count, $list) {
  return array_splice($list, $start, $count);
});

f::define('repeat', function ($x, $count) {
  $ret = [];
  while ($count > 0) {
    $ret[] = $x;
    $count -= 1;
  }
  return $ret;
});

f::define('reverse', function ($list) {
  return array_reverse($list);
});

f::define('scan', function ($fn, $acc, $list) {
  $ii = 0;
  $ll = count($list);
  $ret = [];
  while ($ii < $ll) {
    $acc = $fn($acc, $list[$ii]);
    $ret[$ii + 1] = $acc;
    $ii += 1;
  }
  return $ret;
});

f::define('sequence', function ($of, $traversable) {
  if (method_exists($traversable, 'sequence')) {
    return $traversable->sequence(f::of());
  }
  $reducer = function ($x, $acc) {
    return f::ap(f::map(f::prepend(), $x), $acc);
  };
  return f::reduceRight($reducer, f::of([]), $traversable);
});

f::define('asArray', function ($fn, $list) {
  if (is_string($list)) {
    $res = $fn(str_split($list));
    return implode('', $res);
  }
  return $fn($list);
});

f::define('slice', function ($start, $end, $list) {
  $slice = curry(function ($start, $end, $list) {
    $length = abs($end) - abs($start);
    return f::asArray(function ($list) use ($start, $length) {
      return array_slice($list, $start, $length);
    }, $list);
  });
  return $end
    ? $slice($start, $end, $list)
    : $slice($start, count($list), $list);
});

f::define('take', function ($count, $list) {
  return f::slice(0, $count, $list);
});

f::define('takeLast', function ($count, $list) {
  return f::slice($count * -1, null, $list);
});

f::define('takeWhile', function ($predicate, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if ($predicate($list[$ii])) {
      break;
    }
    $ii += 1;
  }
  return f::take($ii, $list);
});

f::define('splitAt', function ($index, $list) {
  return [
    f::slice(0, $index, $list),
    f::slice($index, count($list), $list)
  ];
});

f::define('splitEvery', function ($every, $list) {
  $ret = [];
  $ii = 0;
  $ll = is_string($list) ? strlen($list) : count($list);
  while ($ii < $ll) {
    $ret[] = f::slice($ii, $ii + $every, $list);
    $ii += $every;
  }
  return $ret;
});

f::define('splitWhen', function ($predicate, $list) {
  $ii = 0;
  $ll = count($list);
  while ($ii < $ll) {
    if ($predicate($list[$ii])) {
      break;
    }
    $ii += 1;
  }
  return f::splitAt($ii, $list);
});

f::define('tail', f::slice(1, null));

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