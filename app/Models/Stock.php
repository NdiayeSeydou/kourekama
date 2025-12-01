<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'nom_produit',
        'quantite_entree',
        'quantite_sortie',
        'prix_unitaire',
        'prix_total',
        'alerte_stock',
        'date',
    ];
}
