<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StocksController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\HomeController;






//route pour la page d'accueil
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('/', function () {
    return view('welcome');
})->name('home');





Route::get('/login', [AuthController::class, 'login'])->name('login');

// Authentification (traitement du formulaire de connexion)
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Protéger toutes les routes suivantes — l'accès requiert une connexion
Route::middleware([\App\Http\Middleware\EnsureAuthenticated::class])->group(function () {

// les produits (ventes)

// affiche de la listes des produits (ventes) avec les produits venant de la bdd
Route::get('/products', [ProductsController::class, 'index'])->name('admin.products.index');

// ajouté un nouveau produit (juste la vue)
Route::get('/products/create', [ProductsController::class, 'create'])->name('admin.products.create');

// ajouter un nouveau produit(avex les données du formulaire)
Route::post('/products/store', [ProductsController::class, 'store'])->name('admin.products.store');

// affiche les détails d'un produit (ID chiffré)
Route::get('/products/{encryptedId}', [ProductsController::class, 'show'])->name('admin.products.show');

// affiche de la page de modification d'un produit
Route::get('/products/{product}/edit',[ProductsController::class, 'edit'])->name('admin.products.edit');

// modifie un produit (avec les nouveaux données saisir)
Route::put('/products/{product}/update',[ProductsController::class, 'update'])->name('admin.products.update');

//supprime un produit des ventes 
Route::delete('/products/delete/{stock}', [ProductsController::class, 'destroy'])->name('admin.products.destroy');

// fin des ventes 


    // pour le pin 
    Route::post('/check-pin', [StocksController::class, 'checkPin'])->name('check.pin');
    Route::post('/update-pin', [StocksController::class, 'updatePin'])->name('update.pin');



//les stocks 
// affiche de la listes des stocks avec les produits venant de la bdd
Route::get('/stocks', [StocksController::class, 'index'])->name('admin.stocks.index');

// ajouté un nouveau stock (juste la vue)
Route::get('/stocks/create', [StocksController::class, 'create'])->name('admin.stocks.create');

// modifier un stock (juste la vue)
Route::get('/stocks/update/{stock}', [StocksController::class, 'edit'])->name('admin.stocks.update');


// ajouté un nouveau stock(avex les données du formulaire)
Route::post('/stocks/store', [StocksController::class, 'store'])->name('admin.stocks.store');

// affiche de details d'un stock 
Route::get('/stocks/{encryptedId}', [StocksController::class, 'show'])->name('admin.stocks.show');

// édition d'une entrée historique 
Route::get('/stocks/entry/{encryptedId}/edit', [StocksController::class, 'editEntry'])->name('admin.stocks.entry.edit');

Route::put('/stocks/entry/{encryptedId}/update', [StocksController::class, 'updateEntry'])->name('admin.stocks.entry.update');
              
Route::delete('/stocks/entry/{encryptedId}', [StocksController::class, 'deleteEntry'])
    ->name('admin.stocks.entry.delete');


// supprimer toutes les entrées d'un produit pour une date donnée
Route::delete('/stocks/{encryptedId}/history/{date}/delete', [StocksController::class, 'deleteEntriesByDate'])->name('admin.stocks.history.delete');

//modifie un stock (avec les nouveaux données saisir)
Route::put('/stocks/update/{encryptedId}', [StocksController::class, 'update'])->name('admin.stocks.update.post');

// ajouter de la quantité à un stock existant
Route::put('/stocks/add-quantity', [StocksController::class, 'addQuantity'])->name('admin.stocks.addquantite');

// Suppression d'un stock
Route::delete('/stocks/delete/{encryptedId}', [StocksController::class, 'destroy'])->name('admin.stocks.destroy');

// fin des stocks




//mon profil


// affiche les paramètres de mon profil
Route::get('/settings', [SettingsController::class, 'settings'])->name('admin.settings');

// pas encore fais le reste update, delete etc...

// Mise à jour des paramètres utilisateur (profil)
Route::post('/settings/update', [SettingsController::class, 'update'])->name('admin.settings.update');

// fin de mon profil 

});


