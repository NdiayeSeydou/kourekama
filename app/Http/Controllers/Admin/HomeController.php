<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;

class HomeController extends Controller
{

    public function index()
    {
        // Récupère tous les produits (ventes)
        $products = Product::latest()->take(5)->get();
        // Enrichit chaque produit avec les informations de stock correspondantes
        foreach ($products as $product) {
            $product->stock = Stock::where('nom_produit', $product->nom_produit)->first();
        }
        return view('dashboard', compact('products'));
    }
}
