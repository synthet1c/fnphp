<?php

class Identity {
    static function of($val) {
        return new Identity($val);
    }
    public function __construct($val) {
        $this->val = $val;
    }
    public function map($fn) {
        return new Identity($fn($this->val));
    }
    public function join() {
        return $this->val;
    }
    public function chain($fn) {
        return $this->call('join', $this->call('map', $fn));
    }
    public function call($method /*, ...$args*/) {
        $args = array_slice(func_get_args(), 1);
        return call_user_func_array([__CLASS__, $method], $args);
    }
}
