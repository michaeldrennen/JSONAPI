<?php

class User {

    public $id;
    public $name;
    public $admin;
    public $department;
    public $city;

    public function __construct( $id = NULL, $name = NULL, $admin = FALSE, $department = NULL, $city = NULL ) {
        $this->id         = $id;
        $this->name       = $name;
        $this->admin      = $admin;
        $this->department = $department;
        $this->city       = $city;
    }
}