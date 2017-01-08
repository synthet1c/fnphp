<?php

class Maybe {
  static function of($val) {
    return new Maybe($val);
  }
  public function __construct($val) {
    $this->value = $val;
  }
  public function map($fn) {
    return is_null($this->value)
      ? $this
      : new Maybe($fn($this->value));
  }
  public function join() {
    return $this->value;
  }
  public function chain($fn) {
    return $this->call('join', $this->call('map', $fn));
  }
  public function call($method /*, ...$args*/) {
    $args = array_slice(func_get_args(), 1);
    return call_user_func_array([__CLASS__, $method], $args);
  }
}

f::define('Maybe', function($x) {
  return Maybe::of($x);
});