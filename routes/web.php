<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AreaInfoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DomainTypeController;
use App\Http\Controllers\ContactTypeController;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\ChildCompanyController;
use App\Http\Controllers\DomainStatusController;
use App\Http\Controllers\TradeReferanceController;
use App\Http\Controllers\AdditionalCompanyController;
use App\Http\Controllers\InterconnectionTypeController;
use App\Http\Controllers\AreaBillingIncrimentController;


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('admin.auth.login');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('countries', CountryController::class);
    Route::get('area_infos/export', [AreaInfoController::class, 'export'])->name('area_infos.export');
    Route::resource('area_infos', AreaInfoController::class);
    Route::post('area_infos/batch_delete', [AreaInfoController::class, 'batchDestroy'])->name('area_infos.batch_delete');
    Route::post('area_infos/import', [AreaInfoController::class, 'import'])->name('area_infos.import'); 
    Route::resource('area_billing_incriments', AreaBillingIncrimentController::class);
    Route::resource('regions', RegionController::class);
    Route::resource('companies', CompanyController::class);
    Route::post('companies/add_domain', [CompanyController::class, 'addDomain'])->name('add_domain');
    Route::delete('companies/remove_domain/{company_id}/{domain_id}', [CompanyController::class, 'removeDomain'])->name('removeDomain');
    Route::resource('additional_companies', AdditionalCompanyController::class);
    Route::post('additional_companies/add_additional_companies', [AdditionalCompanyController::class, 'addName'])->name('addName');
    Route::resource('company_chillds', ChildCompanyController::class);
    Route::post('add_company_chillds', [ChildCompanyController::class,'addChildCompany'])->name('add_company_chillds');
    Route::delete('remove_company_chillds/{parent_id}/{child_company_id}', [ChildCompanyController::class, 'destroy'])->name('removeChild');
    Route::resource('trade_references', TradeReferanceController::class);
    Route::post('add_trade_references', [TradeReferanceController::class,'addTradeReference'])->name('add_trade_references');
     Route::delete('remove_trade_references/{parent_id}/{reference_company_id}', [TradeReferanceController::class, 'destroy'])->name('removeTradeReferences');
    Route::resource('domains', DomainController::class);
    Route::get('domains.public_free', [DomainController::class, 'publicFreeDomain'])->name('public_free_domain');
    Route::get('domain-list', [DomainController::class, 'getDomains'])->name('getDomains');
    Route::resource('domain_types', DomainTypeController::class);
    Route::resource('domain_statuses', DomainStatusController::class);
    Route::resource('tags', TagController::class);
    Route::resource('interconnections', InterconnectionTypeController::class);
    Route::resource('businesstypes', BusinessTypeController::class);
    Route::resource('contacttypes', ContactTypeController::class);
    Route::resource('contacts', ContactController::class);
    Route::resource('logs', LogController::class);
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';
