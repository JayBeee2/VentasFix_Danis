<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Client;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $clientCount = Client::count();
        
        return view('dashboard', compact('userCount', 'productCount', 'clientCount'));
    }
}
