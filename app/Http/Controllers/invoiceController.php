<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class invoiceController extends Controller
{
    public function index(){
        return view('pages.invoice');
    }
}
