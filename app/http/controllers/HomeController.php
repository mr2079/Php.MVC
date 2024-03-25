<?php

namespace App\Http\Controllers;

class HomeController extends Controller {
    public function index() {
        echo "Index in Home";
    }

    public function create() {
        echo "Create in Home";
    }

    public function edit() {
        echo "Edit in Home";
    }
}