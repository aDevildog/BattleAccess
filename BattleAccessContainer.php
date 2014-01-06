<?php
/**
 *
 * @Author      Johnathon "Devildog" Holmes
 * @Version     1.0 (initial)
 * @Package     BattleAccess
 * @Copyright   Copyright (c) 2013, Johnathon "Devildog" Holmes
 *
 */

abstract class BattleAccessContainer implements ArrayAccess
{
    protected $id = null;
    protected $data = null;
    protected $api = null;
    protected $accessUrl = null;

    public function __construct($api, $id, $load = false)
    {
        //$api must be an instance of Battlelog (therefor not null)
        if ($api ==null || !($api instanceof Battlelog))
            throw new Exception ("BattleAccessContainer::__construct: must be passed a Battlelog instance");

        $this->api = $api;
        $this->id = $id;

        if ($load)
            $this->load();
    }

    abstract protected function parseData($data);

    protected function load($force = false) {

        if ($force)
            $this->data = null;

        if ($this->data === null)
        {
            $url = str_replace('[[ID]]', $this->id, $this->accessUrl);
            $data = $this->api->getUrl($url);

            if (strlen($data) < 1)
                throw new Exception ('Error connecting to Battlelog. Check Email/Username');

            $this->data = $this->parseData($data);
        }
    }

    public function get ($name) {
        $this->load();
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }

    public function set ($name, $value) {
        $this->load();
        $this->data[$name] = $value;
    }

    public function offsetGet ($offset) {
        return $this->get($offset);
    }

    public function offsetSet ($offset, $value) {
        return $this->set($offset, $value);
    }

    public function offsetExists ($offset) {
        $this->load();
        return array_key_exists($offset, $this->data);
    }

    public function offsetUnset($offset) {
        throw new Exception ('Unsupported');
    }
}