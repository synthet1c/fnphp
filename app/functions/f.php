<?php

/**
 * @class f
 *
 * ### LOGIC ###
 *
 * @method static  Boolean  allPass(Array $conditions)
 * @method static  Boolean  and(mixed $a, mixed $b) true if both arguments are true
 * @method static  Boolean  both(Mixed $a, Mixed $b)
 * @method static  Mixed    complement(Callable $fn) call the $fn and return the opposite value
 * @method static  Callable cond(Array $conditions) returns a function that wraps if else conditionals
 *
 * @method static  Boolean  equals(Mixed $x, Mixed $y)
 * @method static  Array    adjust(Callable $fn, Number $n, Array $list)
 * @method static  boolean  all(Callable $predicate, Array $list)
 * @method static  Mixed    always(mixed $val)  always return a provided value
 * @method static  Boolean  any(Callable $predicate, Array $list) test if any $list value satisfies the $predicate
 * @method static  Array    ap($applicitive, Callable $fn)
 * @method static  Array    aperture(Number $length, Array $list)
 * @method static  Array    append($x, $list)
 * @method static  Mixed    apply($fn, $arguments)
 * @method static  Mixed    applySpec($spec, $list)
 * @method static  Number   ascend($fn, $a, $b)
 * @method static  Array    assoc($prop, $val, $obj) make a shallow copy of the provided object, with the new property added
 * @method static  Array    assocPath($path, $val, $obj) make a shallow copy of the provided object, with the new property added
 * @method static  Callable binary(Callable $fn) wraps Callable function with function that expects 2 arguments
 * @method static  Boolean  both(Callable $a, Callable $b)
 * @method static  Callable call($fn, ...$arguments) call $fn with remaining $arguments
 * @method static  Array    chain($fn, $list)
 * @method static  Number   clamp(Number $min, Number $max, Number $n) restricts a number to be within the given range
 * @method static  Object   clone(Object $objects) deep copy an object or array
 * @method static  Number   comparator($fn)
 * @method static  Callable compose($f, $g)($x)
 * @method static  Callable composeK($f, $g)($x) kleisli combinator, returned value of composed functions must have a `chain` method
 * @method static  Promise  composeP($f, $g)->then($x)
 * @method static  Array    concat($x, $xs) concatenate $x to end of $xs
 * @method static  Boolean  contains($x, $list) if $list contains $x
 * @method static  Callable converge()
 *
 * ### LISTS ###
 *
 * @method static  Array    drop(Number $index, Array $list) remove item at $index from $list
 * @method static  Array    dropLast(Number $index, Array $list) remove item at $index from $list starting from end of array
 * @method static  Array    dropWhileLast(Callable $predicate, Array $list) remove elements that satisfy the $predicate function
 * @method static  Array    dropRepeats(Array $list) remove duplicate values from the $list
 * @method static  Array    dropRepeatsWith(Callable $transducer, Array $list)
 * @method static  Array    dropWhile(Callable $predicate, Array $list) remove elements that satisfy the $predicate function
 * @method static  Array    filter(Callable $predicate, Array $list) remove items from an array that do not satisfy the $predicate function
 * @method static  Mixed    find(Callable $predicate, Array $list) returns the first element that satisfies the $predicate
 * @method static  Number   findIndex(Callable $predicate, Array $list) returns the first index that satisfies the $predicate
 * @method static  Mixed    findLast(Callable $predicate, Array $list) returns the last element that satisfies the $predicate
 * @method static  Mixed    findLastIndex(Callable $predicate, Array $list) returns the last index that satisfies the $predicate
 * @method static  Array    flatten(Array $list) return a flattened multidimensional array
 * @method static  Array    forEach(Callable $fn, Array $list) run the $fn over each item in the $list
 * @method static  Array    fromPairs(Array $list) [['a', 1], ['b', 2]] => ['a' => 1, 'b' => 2]
 * @method static  Array    groupBy(Callable $fn, Array $list)
 * @method static  Array    groupWith(Callable $fn, Array $list)
 * @method static  Mixed    head(Array|String $list) return the first item in a list
 * @method static  Array    indexBy(Callable $getter, Array $list)
 * @method static  Number   indexOf(Mixed $x, Array $xs) returns index of item in array
 * @method static  Array    init(Array $list) return all elements in a $list but the last item
 * @method static  Array    insert(Mixed $x, Array $insert, Array $list)
 * @method static  Array    intersperse(Mixed $separator, Array $list) create a new list with separator interspersed between elements
 * @method static  Array    into()
 * @method static  String   join(String $joiner, Array $list)
 * @method static  Mixed    last(Array $list) return last item in a $list
 * @method static  Number   lastIndexOf(Mixed $x, Array $list)
 * @method static  Number   length(Array $list)
 * @method static  Array    map(Callable $fn, Array $list)
 * @method static  Array    mapAccum(Callable $fn, Mixed $initial, Array $list)
 * @method static  Array    merge(Array ...$lists) merge all lists into single array
 * @method static  Array    mergeAll(Array $lists) merge all lists into single array
 * @method static  Array    mergeWith(Callable $fn, Array ...$lists) merge all lists into single array
 * @method static  Array    mergeWithKey(Callable $fn, Array ...$lists) merge all lists into single array
 * @method static  Boolean  none(Callable $predicate, Array $list) true if no elements match the $predicate function
 * @method static  Mixed    nth(Mixed $x, Array|String $xs) return item an $x index
 * @method static  Array    pair(Mixed $x, Mixed $y) return array with [$x, $y]
 * @method static  Array    partition(Callable $fn, Array $list)
 * @method static  Array    pluck(Mixed $index, Array $list) Return new list by plucking the same named property off all objects in the supplied $list
 * @method static  Array    prepend(Mixed $x, $list) return a new list with $x prepended to the front
 * @method static  Array    range(Number $from, Number $to) return array containing a numbers from $from to $to
 * @method static  Mixed    reduce(Callable $accumulator, Mixed $initial, Array $list)
 * @method static  Mixed    reduceBy(Callable $accumulator, Callable $reducer, Array $list)
 * @method static  Mixed    reduceWhile(Callable $accumulator, Callable $reducer, Array $list)
 * @method static  Mixed    reject(Callable $predicate, Array $list) remove items that satisfy the $predicate
 * @method static  Array    remove(Number $index, Number $count, Array $list)
 * @method static  Array    repeat(Mixed $x, Number $count)
 * @method static  Array    reverse(Array $list) return a new list or string with elements or characters in reverse order
 * @method static  Array    scan(Callable $fn, Mixed $initial, Array $list)
 * @method static  Array    sequence()
 * @method static  Array    slice(Number $index, Number $count, Array $list)
 * @method static  Array    sort(Callable $sorter, Array $list)
 * @method static  Array    splitAt(Number $index, Array|String $list)
 * @method static  Array    splitEvery(Number $count, Array|String $list)
 * @method static  Array    splitWhen(Callable $predicate, Array|String $list)
 * @method static  Array    tail(Array $list)
 * @method static  Array    take(Number $count, Array $list)
 * @method static  Array    takeLast(Number $count, Array $list)
 * @method static  Array    takeLastWhile(Callable $predicate, Array $list)
 * @method static  Array    takeWhile(Callable $predicate, Array $list)
 * @method static  Array    times(Callable $fn, Number $count)
 * @method static  Array    transduce(Callable $transducer, Callable $fn, Array $initial, Array $list)
 * @method static  Array    transpose(Array $pairs)
 * @method static  Array    traverse(Callable $of, Callable $fn, Array $traversable)
 * @method static  Array    unfold(Callable $fn, Array $list)
 * @method static  Array    uniq(Array $list)
 * @method static  Array    uniqBy(Callable $fn, Array $list)
 * @method static  Array    uniqWith(Callable $fn, Array $list)
 * @method static  Array    unnest(Array $list)
 * @method static  Array    update(Number $index, Mixed $value, Array $list)
 * @method static  Array    without(Array $remove, Array $list)
 * @method static  Array    xprod(Array $a, Array $b)
 * @method static  Array    zip(Array $a, Array $b)
 * @method static  Array    zipObj(Array $a, Array $b)
 * @method static  Array    zipWith(Callable $f, Array $a, Array $b)
 *
 */
class f {
  private static $__methods__ = [];

//  public static function initialize($__methods__ = []) {
//    self::$__methods__ = array_merge(self::$__methods__, $__methods__);
//  }

  public static function define($name, $fn, $doCurry = true) {
    if ($doCurry === true) {
      self::$__methods__[$name] = curry($fn);
    }
    elseif (is_numeric($doCurry)) {
      self::$__methods__[$name] = curryN($doCurry, $fn);
    }
    else {
      self::$__methods__[$name] = $fn;
    }
  }
  public static function __callStatic($name, $args) {
    if (isset(self::$__methods__[$name])) {
      return call_user_func_array(self::$__methods__[$name], $args);
    }
    if (function_exists($name)) {
      return call_user_func_array($name, $args);
    }
    throw new Exception("no function f::{$name}");
  }
}

// f::initialize($__methods__);
f::define('pipe', function(/*...$args*/) {
  $fns = func_get_args();
  return function($val) use ($fns) {
    return array_reduce($fns, function($acc, $fn) {
      return $fn($acc);
    }, $val);
  };
});


f::define('flip', function($fn) {
  return curryN(1, function(/* ...$args */) use ($fn) {
    $args = array_reverse(func_get_args());
    return call_user_func_array($fn, $args);
  });
});


f::define('compose2', function($a, $b) {
  return function($c) use ($a, $b) {
    return $a($b($c));
  };
});


f::define('compose', function(/*...$args*/) {
  $fns = array_reverse(func_get_args());
  return function($val) use ($fns) {
    return array_reduce($fns, function($acc, $fn) {
      return $fn($acc);
    }, $val);
  };
});

f::define('complement', function($fn) {
  return curryN(1, function(...$args) use ($fn) {
    return !call_user_func_array($fn, $args);
  });
});

f::define('map',function($fn, $functor) {
  return (is_array($functor))
    ? array_map($fn, $functor)
    : $functor->map($fn);
});

f::define('add', function($a, $b) {
  return $a + $b;
});

f::define('multiply', function($first, $second) {
  return $first * $second;
});

f::define('prepend', function($first, $second) {
  return f::concat([$first], $second);
});

f::define('append', function($first, $second) {
  return f::concat($second, $first);
});
