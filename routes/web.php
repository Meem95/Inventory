<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* artisan command */
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return 'cache clear';
});
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return 'config:cache';
});
Route::get('/view-cache', function() {
    $exitCode = Artisan::call('view:cache');
    return 'view:cache';
});
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return 'view:clear';
});
/* artisan command */





Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::get('change-password/{id}','UserController@changedPassword')->name('password.change_password');
    Route::post ('change-password-update','UserController@changedPasswordUpdated')->name('password.change_password_update');

    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    Route::resource('stores','StoreController');
    Route::resource('stores','StoreController');
    Route::resource('productCategories','ProductCategoryController');
    Route::resource('productSubCategories','ProductSubCategoryController');
    Route::resource('productBrands','ProductBrandController');
    Route::resource('productUnits','ProductUnitController');
    Route::resource('products','ProductController');
    Route::resource('party','PartyController');
    Route::resource('productPurchases','ProductPurchaseController');
    Route::resource('productSales','ProductSaleController');
    Route::resource('productSaleReturns','ProductSaleReturnController');
    Route::resource('officeCostingCategory','OfficeCostingCategoryController');
    Route::resource('expenses','ExpenseController');
    Route::resource('productPurchaseRawMaterials','ProductPurchaseRawMaterialsController');
    Route::resource('productProductions','ProductProductionController');


    Route::get('party-balance','ProductPurchaseController@partyBalance')->name('party.balance');
    Route::post('party-balance/show','ProductPurchaseController@partyBalanceShow')->name('party_balance.show');


    Route::get('productPurchases-invoice','ProductPurchaseController@invoice')->name('productPurchases-invoice');
    Route::get('productPurchases-invoice-print','ProductPurchaseController@invoicePrint')->name('productPurchases-invoice-print');
    Route::get('productSales-invoice/{id}','ProductSaleController@invoice')->name('productSales-invoice');
    Route::get('productSales-invoice-print/{id}','ProductSaleController@invoicePrint')->name('productSales-invoice-print');
    Route::get('productSales-invoice-edit/{id}','ProductSaleController@invoiceEdit')->name('productSales-invoice-edit');
    Route::post('productSales-invoice-update/{id}','ProductSaleController@updateInvoice')->name('productSales.invoiceUpdate');
    Route::get('sub-category-list','ProductController@subCategoryList');
    Route::get('check-barcode','ProductController@checkBarcode');
    Route::get('product-relation-data','ProductPurchaseController@productRelationData');
    Route::get('product-sale-relation-data','ProductSaleController@productSaleRelationData');
    Route::get('stock-list','StockController@stockList')->name('stock.index');
    Route::get('stock-purchase-list','StockController@stockPurchaseList')->name('stock.purchase.index');
    Route::get('returnable-sale-product-list','ProductSaleReturnController@returnableSaleProduct')->name('returnable.sale.product');
    Route::post('sale-product-return','ProductSaleReturnController@saleProductReturn')->name('sale.product.return');
    Route::get('transaction-list','TransactionController@transactionList')->name('transaction.index');
    Route::get('transaction-loss-profit','TransactionController@lossProfit')->name('transaction.lossProfit');
    Route::get('delivery-list','TransactionController@deliveryList')->name('delivery.index');
    Route::post('party/new-party','ProductSaleController@newParty')->name('parties.store.new');
    Route::post('party/supplier/new-party','ProductPurchaseController@newParty')->name('parties.supplier.store.new');
    Route::post('pay-due','ProductSaleController@payDue')->name('pay.due');
    Route::get('productSales-customer-due','ProductSaleController@customerDue')->name('productSales.customer.due');
    Route::post('party/new-office-costing-category','ExpenseController@newOfficeCostingCategory')->name('office.costing.category.new');
    Route::get('product-production-relation-data','ProductProductionController@productProductionRelationData');




    Route::get('productPosSales/list','ProductPosSaleController@index')->name('productPosSales.index');
    Route::get('productPosSales','ProductPosSaleController@create')->name('productPosSales.create');
    Route::get('sale/{id}/data', 'ProductPosSaleController@listData')->name('sale.data');
    Route::get('sale/loadform/{discount}/{total}/{paid}', 'ProductPosSaleController@loadForm');

    Route::get('gauzeClothSales/list','GauzeStockOutController@index')->name('gauzeClothSales.index');
    Route::get('gauzeClothSales','GauzeStockOutController@create')->name('gauzeClothSales.create');
    Route::get('sale/{id}/data', 'GauzeStockOutController@listData')->name('sale.data');
    Route::get('sale/loadform/{discount}/{total}/{paid}', 'GauzeStockOutController@loadForm');


    Route::get('pos/print/{id}/{status}', 'PointOfSaleController@print')->name('pointOfSale.print');
    Route::get('pos/print_pos/{id}/{status}', 'PointOfSaleController@printPos')->name('pointOfSale.print2');
    Route::get('pos/print2/{id}/{status}', 'PointOfSaleController@print2')->name('pointOfSale.print2');

    Route::get('product-pos-sales-invoice/{id}/{status}','PointOfSaleController@invoicePos')->name('product.pos.sales-invoice');
    Route::get('product-pos-sales-invoice-print/{id}','PointOfSaleController@invoicePosPrint')->name('product.pos.Sales-invoice-print');


    Route::get('selectedform/{product_code}','ProductPosSaleController@selectedform');
    Route::get('add-to-cart','CartController@addToCart');
    Route::get('update-cart-product/{rowId}/{qty}','CartController@updateCartProduct');
    Route::get('delete-cart-product/{rowId}','CartController@deleteCartProduct');
    Route::get('delete-all-cart-product','CartController@deleteAllCartProduct');
    Route::post('pos_insert', 'ProductPosSaleController@postInsert');

//
//    Route::get('selected_form/{product_code}','GauzeStockOutController@selectedform');
//    Route::post('pos_insert', 'GauzeStockOutController@postInsert');


    // stock sync
    Route::get('stock_sync','StockController@stock_sync')->name('stock_sync');

    //excel
    Route::get('export', 'UserController@export')->name('export');
    Route::get('importExportView', 'ExportExcelController@importExportView');
    Route::post('import', 'ExportExcelController@import')->name('import');

    Route::get('transaction/export/', 'TransactionController@export')->name('transaction.export');
    Route::get('delivery/export/', 'TransactionController@deliveryExport')->name('delivery.export');
    Route::get('loss-profit/export/', 'TransactionController@lossProfitExport')->name('loss.profit.export');
    Route::get('loss-profit-filter-export/{start_date}/{end_date}','TransactionController@lossProfitExportFilter')->name('loss.profit.filter.export');
    Route::get('stock/export/', 'StockController@export')->name('stock.export');

    // custom start
    Route::post('/roles/permission','RoleController@create_permission');
    Route::post('/store/active','StoreController@activeDeactive')->name('store.active');
    Route::post('/user/active','UserController@activeDeactive')->name('user.active');
});
