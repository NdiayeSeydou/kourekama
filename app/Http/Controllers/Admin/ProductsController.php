<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{

    // Liste des produits 
    public function index()
    {
        // Récupère tous les produits (ventes)
        $products = Product::latest()->paginate(12);
        // Enrichit chaque produit avec les informations de stock correspondantes
        foreach ($products as $product) {
            $product->stock = Stock::where('nom_produit', $product->nom_produit)->first();
        }
        return view('produits.listes', compact('products'));
    }


    // Affiche les détails d'un produit (ID chiffré)
    public function show($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $produit = Product::findOrFail($id);
        $produit->stock = Stock::where('nom_produit', $produit->nom_produit)->first();

        return view('produits.show', compact('produit'));
    }

    // affiche la page d'ajout du produit 
    public function create()
    {
        // Pour proposer une liste des produits disponibles dans le stock
        $stocks = Stock::all();
        return view('produits.add', compact('stocks'));
    }

    // add le produit 
    public function store(Request $request)
    {
        // on valide sous forme de tableau
        $validated = $request->validate([
            'nom_produit.*' => 'required|string',
            'quantite.*' => 'required|integer|min:1',
            'prix_unitaire.*' => 'required|numeric|min:0',
            'image.*' => 'nullable|image|max:2048',
            'date.*' => 'nullable|date'
        ]);

        $count = count($request->nom_produit);

        for ($i = 0; $i < $count; $i++) {
            $nomProduit = $request->nom_produit[$i];
            $quantite = $request->quantite[$i];
            $prixUnitaire = $request->prix_unitaire[$i];

            // Vérifier stock
            $stock = Stock::where('nom_produit', $nomProduit)->first();
            if (!$stock) {
                return back()->withErrors(['nom_produit' => "Le produit $nomProduit n’existe pas dans le stock."]);
            }

            $quantiteDisponible = $stock->quantite_entree - $stock->quantite_sortie;
            if ($quantite > $quantiteDisponible) {
                return back()->withErrors(['quantite' => "Stock insuffisant pour $nomProduit. Disponible : $quantiteDisponible"]);
            }

            // Upload image individuelle
            $imagePath = null;
            if ($request->hasFile("image.$i")) {
                $imagePath = $request->file("image.$i")->store('produits', 'public');
            }

            // Calcul prix total
            $prixTotal = $quantite * $prixUnitaire;

            // Enregistrer la vente
            $productData = [
                'nom_produit' => $nomProduit,
                'quantite' => $quantite,
                'prix_unitaire' => $prixUnitaire,
                'prix_total' => $prixTotal,
                'image' => $imagePath,
            ];

            // ajouter la date si fournie
            if (isset($request->date[$i]) && $request->date[$i]) {
                // convertir en format SQL
                $productData['date'] = date('Y-m-d H:i:s', strtotime($request->date[$i]));
            }

            Product::create($productData);

            // Mise à jour du stock
            $stock->quantite_sortie += $quantite;
            $stock->prix_total = ($stock->quantite_entree - $stock->quantite_sortie) * $stock->prix_unitaire;
            $stock->save();
        }

        return redirect()->route('admin.products.index')->with('success', 'Toutes les ventes ont été enregistrées et le stock mis à jour.');
    }


    // affiche la page de update 
    public function edit($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $produit = Product::findOrFail($id);
        return view('produits.update', compact('produit'));
    }

    // update le produit 
    public function update(Request $request, $encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);
        $produit = Product::findOrFail($id);
        $data = $request->validate([
            'nom_produit' => 'required|string',
            'quantite' => 'required|integer|min:1',
            'prix_unitaire' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'date' => 'nullable|date'
        ]);

        $stock = Stock::where('nom_produit', $data['nom_produit'])->first();
        if (!$stock) {
            return back()->withErrors(['nom_produit' => 'Ce produit n’existe pas dans le stock.']);
        }

        // On restitue d’abord l’ancienne quantité au stock
        $stock->quantite_sortie -= $produit->quantite;
        if ($stock->quantite_sortie < 0) $stock->quantite_sortie = 0;

        // Vérification quantité disponible avec la nouvelle valeur
        $quantiteDisponible = $stock->quantite_entree - $stock->quantite_sortie;
        if ($data['quantite'] > $quantiteDisponible) {
            // On remet le stock comme avant
            $stock->quantite_sortie += $produit->quantite;
            return back()->withErrors(['quantite' => 'Stock insuffisant. Quantité disponible : ' . $quantiteDisponible]);
        }

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('produits', 'public');
        }

        $data['prix_total'] = $data['quantite'] * $data['prix_unitaire'];

        // gérer la date si fournie
        if ($request->filled('date')) {
            $data['date'] = date('Y-m-d H:i:s', strtotime($request->input('date')));
        }

        $produit->update($data);

        // Mise à jour du stock avec la nouvelle quantité
        $stock->quantite_sortie += $data['quantite'];
        $stock->prix_total = ($stock->quantite_entree - $stock->quantite_sortie) * $stock->prix_unitaire;
        $stock->save();

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour et stock ajusté.');
    }


    //Supprimer un produit (vente)
    public function destroy($encryptedId)
    {
        $id = Crypt::decrypt($encryptedId);

        $produit = Product::findOrFail($id);

        // Récupérer le stock correspondant au nom du produit
        $stock = Stock::where('nom_produit', $produit->nom_produit)->first();

        // Tenter de copier physiquement l'image du produit vers le dossier 'stocks' (storage public)
        $copiedImagePath = null;
        if (!empty($produit->image) && Storage::disk('public')->exists($produit->image)) {
            $originalFilename = basename($produit->image);
            $targetPath = 'stocks/' . time() . '_' . $originalFilename;
            try {
                Storage::disk('public')->copy($produit->image, $targetPath);
                $copiedImagePath = $targetPath;
            } catch (\Exception $e) {
                // Si la copie échoue, on ignore et on utilisera le chemin original si nécessaire
                $copiedImagePath = null;
            }
        }

        if ($stock) {
            // Réduire la quantité sortie (restaurer la quantité vendue)
            $stock->quantite_sortie -= $produit->quantite;
            if ($stock->quantite_sortie < 0) {
                $stock->quantite_sortie = 0;
            }

            // Recalculer le prix_total en fonction de la quantité restante
            $quantite_dispo = $stock->quantite_entree - $stock->quantite_sortie;
            $stock->prix_total = $quantite_dispo * $stock->prix_unitaire;

            // Si le stock n'a pas d'image, tenter d'utiliser l'image du produit (préférer la copie)
            if (empty($stock->image) && ($copiedImagePath || !empty($produit->image))) {
                $stock->image = $copiedImagePath ?? $produit->image;
            }

            $stock->save();
        } else {
            // Si aucun stock n'existe pour ce produit, créer un enregistrement de stock
            Stock::create([
                'nom_produit' => $produit->nom_produit,
                'quantite_entree' => $produit->quantite,
                'quantite_sortie' => 0,
                'prix_unitaire' => $produit->prix_unitaire,
                'prix_total' => $produit->quantite * $produit->prix_unitaire,
                'image' => $copiedImagePath ?? ($produit->image ?? null),
                'alerte_stock' => 5,
            ]);
        }

        // Supprimer la vente
        $produit->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé et stock ajusté.');
    }
}
