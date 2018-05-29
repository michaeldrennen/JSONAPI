<?php

class User {

    public $id;
    public $name;
    public $admin;

    public function __construct( $id = NULL, $name = NULL, $admin = FALSE ) {
        $this->id    = $id;
        $this->name  = $name;
        $this->admin = $admin;
    }
}