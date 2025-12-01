<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;


    protected $table = 'ventes';
    protected $fillable = [
        'image',
        'nom_produit',
        'quantite',
        'prix_unitaire',
        'prix_total',
        'date',
    ];


    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}
