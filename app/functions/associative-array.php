<?php

function fclone($object) {
  $result = [];
  $isObject = is_object($object);
  forEach ($object as $key => $value) {
    if (is_array($value)) {
      $result[$key] = is_array($value)
        ? fclone($value)
        : $value;
    }
  }
  return $isObject
    ? (object) $result
    : $result;
}

f::define('clone', 'fclone');

f::define('dissoc', function($prop, $object) {
  $result = [];
  $isObject = is_object($object);
  forEach ($object as $key => $value) {
    if ($key === $prop) continue;
    $result[$key] = $value;
  }
  return $isObject
    ? (object) $result
    : $result;
});

f::define('dissocPath', function() {
  throw new Exception('need to declare dissocPath');
});

f::define('eqProps', function($prop, $o1, $o2) {
  return $o2[$prop] === $o2[$prop];
});

function fevolve($transformations, $object) {
  $result = [];
  $isObject = is_object($object);
  forEach ($object as $key => $value) {
    $transformation = isset($transformations[$key]) ? $transformations[$key] : false;
    $result[$key] = (is_callable($transformation)
      ? $transformation($value)
      : (is_array($transformation)
        ? fevolve($transformation, $value)
        : $value));
  }
  return $isObject
    ? (object) $result
    : $result;
}

f::define('evolve', 'fevolve');

f::define('forEachObjIndexed', function($fn, $object) {
  forEach ($object as $key => $value) {
    $fn($value, $key, $object);
  }
  return $object;
});

f::define('has', function($prop, $object) {
  return (is_object($object)
    ? isset($object->value)
    ? isset($object->value->$prop)
      : isset($object->$prop)
    : isset($object[$prop]));
});

f::define('invert', function($object) {
  $result = [];
  forEach ($object as $key => $value) {
    if (isset($result[$key])) {
      array_push($result[$value], $key);
    }
    else {
      $result[$value] = [$key];
    }
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('invertObj', function($object) {
  $result = [];
  forEach ($object as $key => $value) {
    $result[$value] = [$key];
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('keys', function($object) {
  return array_keys((array) $object);
});

f::define('mapObjIndexed', function($fn, $object) {
  $result = [];
  forEach ($object as $key => $value) {
    $result[$key] = $fn($value, $key, $object);
  }
  return is_object($object)
    ? (object) $object
    : $object;
});

f::define('merge', function($o1, $o2) {
  $result = array_merge((array) $o1, (array) $o2);
  return is_object($o2)
    ? (object) $result
    : $result;
});

f::define('mergeAll', function(...$objects) {
  $first = array_unshift($objects);
  $result = array_reduce($objects, function($acc, $x) {
    return array_merge($acc, (array) $x);
  }, (array) $first);
  return is_object($objects[0])
    ? (object) $result
    : $result;
});

f::define('mergeAll', function(...$objects) {
  $result = array_reduce($objects, function($acc, $x) {
    return array_merge($acc, $x);
  }, []);
  return is_object($o2)
    ? (object) $result
    : $result;
});