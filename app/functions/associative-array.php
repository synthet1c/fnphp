<?php

f::define('clone', function($object) {
  $result = [];
  $isObject = is_object($object);
  forEach ($object as $key => $value) {
    if (is_array($value)) {
      $result[$key] = is_array($value)
        ? f::clone($value)
        : $value;
    }
  }
  return $isObject
    ? (object) $result
    : $result;
});

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

f::define('evolve', function($transformations, $object) {
  $result = [];
  forEach ($object as $key => $value) {
    $transformation = isset($transformations[$key]) ? $transformations[$key] : false;
    $result[$key] = (is_callable($transformation)
      ? $transformation($value)
      : (is_array($transformation) || is_object($transformations)
        ? f::evolve($transformation, $value)
        : $value));
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

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
}, 1);

f::define('mergeWith', function($fn, $o1, $o2) {
  $result = is_callable($fn)
    ? call_user_func($fn, (array) $o1, (array) $o2)
    : array_merge((array) $o1, (array) $o2);
  return is_object($o2)
    ? (object) $result
    : $result;
}, 2);

f::define('mergeWithKey', function() {
  throw new Exception('need to define mergeWithKey');
});

f::define('objOf', function() {
  throw new Exception('need to define objOf');
});

f::define('omit', function($keys, $object) {
  $result = [];
  forEach ($object as $key => $value) {
    if (in_array($key, $keys)) continue;
    $result[$key] = $value;
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('pick', function($keys, $object) {
  $result = [];
  forEach ($keys as $key) {
    if (!isset($object[$key])) continue;
    $result[$key] = $object[$key];
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('pickAll', function($keys, $object) {
  $result = [];
  forEach ($keys as $key) {
    $result[$key] = isset($object[$key])
      ? $object[$key]
      : null;
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('pickBy', function($fn, $object) {
  $result = [];
  forEach ($object as $key => $value) {
    if ($fn($value, $key)) {
      $result[$key] = $value;
    }
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('project', function($keys, $objects) {
  $result = [];
  forEach ($objects as $object) {
    $result[] = f::pick($keys, $object);
  }
  return is_object($object)
    ? (object) $result
    : $result;
});

f::define('propOr', function($or, $prop, $object) {
  $result = is_object($object)
    ? $object->$prop
    : $object[$prop];
  return $result
    ? $result
    : $or;
});

f::define('props', function($props, $object) {
  $result = [];
  forEach ($object as $key => $value) {
    if (in_array($key, $props)) {
      $result[] = $value;
    }
  }
  return $result;
});

f::define('set', function($lens, $value, $object) {
  return f::over($lens, f::always($value), $object);
});

f::define('toPairs', function($object) {
  $result = [];
  forEach ($object as $key => $value) {
    $result[] = [$key, $value];
  }
  return $result;
});

f::define('values', function($object) {
  return array_values((array) $object);
});

f::define('where', function($conditions, $object) {
  forEach ($object as $key => $value) {
    if (!$conditions[$key]($value)) {
      return false;
    }
  }
  return true;
});

f::define('whereEq', function($conditions, $object) {
  forEach ($conditions as $key => $value) {
    if (!$conditions[$key]($object[$key])) {
      return false;
    }
  }
  return true;
});