<?php

namespace App\Http\Controllers\Back;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    //
    public function index()
    {
      return view('Back.order.index');
    }

    public function create()
    {
        return view('Back.order.create');
    }

    public function store(Request $request)
    {
        # code...
    }

    public function edit(Order $order)
    {

    }

    public function update(Order $order, $id)
    {
        # code...
    }
}
