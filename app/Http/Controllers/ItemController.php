<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    
public function index()
{
    $items = Item::with('pemeliharaans')
        ->orderBy('studio')
        ->orderBy('nama_barang')
        ->get();

    return view('management.items', compact('items'));
}


    public function create()
    {
        return view('management.create-item');
    }
}