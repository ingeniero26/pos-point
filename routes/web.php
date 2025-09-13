<?php

use App\Http\Controllers\AccountBankController;
use App\Http\Controllers\AccountDocumentSourceController;
use App\Http\Controllers\AccountingMovementController;
use App\Http\Controllers\AccountingAccountTypeController;
use App\Http\Controllers\AccountingDocumentController;
use App\Http\Controllers\AccountsPayableController;
use App\Http\Controllers\AccountsReceivableController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BankingInstitutionsController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CashMovementController;
use App\Http\Controllers\CashRegisterController;

use App\Http\Controllers\CashRegisterSessionController;
use App\Http\Controllers\CitysController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\CommunicateController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CostCentersController;

use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\IdentificationTypeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\ItemTypesController;
use App\Http\Controllers\MeasuresController;
use App\Http\Controllers\MovementCategoryController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentFormController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PaymentsPurchasesController;
use App\Http\Controllers\PaymentsSalesController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\Purchase2Controller;
use App\Http\Controllers\PurchaseOrder2Controller;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PurchaseTempController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\DocumentTypeController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TypeLiabilityController;
use App\Http\Controllers\TypeMovementCashController;
use App\Http\Controllers\TypeRegimenController;

use App\Http\Controllers\UserSalesController;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ListPriceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\InvoiceGroupController;
use App\Http\Controllers\NotesConceptController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetLocationController;
use App\Http\Controllers\NotesCreditDebitController;
use App\Http\Controllers\ReceiptTypeController;
use App\Http\Controllers\AdjustmentReasonController;
use App\Http\Controllers\BranchTypeController;
use App\Http\Controllers\InventoryAjustmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/about', [HomeController::class, 'about'])->name('home.about');
Route::get('/contact', [HomeController::class, 'contact'])->name('home.contact');
Route::get('/services', [HomeController::class, 'services'])->name('home.services');
Route::get('/team', [HomeController::class, 'team'])->name('home.team');
Route::get('/blog', [HomeController::class, 'blog'])->name('home.blog');
Route::get('/blog-single', [HomeController::class, 'blogSingle'])->name('home.blog-single');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('home.portfolio');

Route::get('/', [AuthController::class, 'login']);
Route::post('/login_post', [AuthController::class, 'login_post']);
Route::get('forgot-password', [AuthController::class, 'forgotpassword']);
Route::post('forgot-password', [AuthController::class, 'PostForgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'PostReset']);
//
Route::get('register', [AuthController::class, 'register']);
Route::post('register_post', [AuthController::class, 'register_post']);


Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard']);
    Route::get('admin/dashboard/totales', [DashboardController::class, 'getTotales'])->name('dashboard.totales');
    Route::get('admin/logout', [AuthController::class, 'logout']);
    //listado de administradores
    Route::get('admin/admin/list', [AdminController::class, 'list'])->name('admin.admin.list');
    Route::get('admin/admin/data', [AdminController::class, 'getAdmins'])->name('admin.admin.fetch');
    Route::post('admin/admin/store', [AdminController::class, 'store'])->name('admin.admin.store');
    Route::get('admin/admin/edit/{id}', [AdminController::class, 'edit'])->name('admin.admin.edit');
    Route::post('admin/admin/update/{id}', [AdminController::class, 'update'])->name('admin.admin.update');
    Route::delete('admin/admin/delete/{id}', [AdminController::class, 'destroy']);
    Route::put('admin/admin/toggle-status/{id}', [AdminController::class, 'toggleStatus'])->name('admin.admin.toggle-status');

    // grupo de inventario 
    Route::get('admin/invoice_group/list', [InvoiceGroupController::class, 'list'])->name('admin.invoice_group.list');
    Route::get('admin/invoice_group/data', [InvoiceGroupController::class, 'getInvoiceGroups'])->name('admin.invoice_group.fetch');
    Route::post('admin/invoice_group/store', [InvoiceGroupController::class, 'store'])->name('admin.invoice_group.store');
    Route::get('admin/invoice_group/edit/{id}', [InvoiceGroupController::class, 'edit'])->name('admin.invoice_group.edit');
    Route::POST('admin/invoice_group/update/{id}', [InvoiceGroupController::class, 'update'])->name('admin.invoice_group.update');
    Route::delete('admin/invoice_group/delete/{id}', [InvoiceGroupController::class, 'destroy'])->name('admin.invoice_group.delete');

    //category
    Route::get('admin/category/list', [CategoryController::class, 'list']);
    Route::get('admin/category/data', [CategoryController::class, 'getCategories']);
    Route::post('admin/category/store', [CategoryController::class, 'store']);
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit']);
    Route::POST('admin/category/update/{id}', [CategoryController::class, 'update']);
    Route::delete('admin/category/delete/{id}', [CategoryController::class, 'destroy']);

    // subcategory
    Route::get('admin/subcategory/list', [SubCategoryController::class, 'list'])->name('admin.subcategory.list');
    Route::get('admin/subcategory/data', [SubCategoryController::class, 'getSubCategories'])->name('admin.subcategory.fetch');
    Route::post('admin/subcategory/store', [SubCategoryController::class, 'store'])->name('admin.subcategory.store');
    Route::get('admin/subcategory/edit/{id}', [SubCategoryController::class, 'edit'])->name('admin.subcategory.edit');
    Route::POST('admin/subcategory/update/{id}', [SubCategoryController::class, 'update'])->name('admin.subcategory.update');
    Route::delete('admin/subcategory/delete/{id}', [SubCategoryController::class, 'destroy']);
    Route::get('admin/subcategory/{id}', [SubCategoryController::class, 'show'])->name('admin.subcategory.show');

    //warehouse
    Route::get('admin/warehouse/list', [WarehouseController::class, 'index']);
    Route::get('admin/warehouse/data', [WarehouseController::class, 'getWarehouses']);
    Route::post('admin/warehouse/store', [WarehouseController::class, 'store']);
    Route::get('admin/warehouse/edit/{id}', [WarehouseController::class, 'edit']);
    Route::POST('admin/warehouse/update/{id}', [WarehouseController::class, 'update']);
    Route::delete('admin/warehouse/delete/{id}', [WarehouseController::class, 'destroy']);

    // brands
    Route::get('admin/brand/list', [BrandController::class, 'list']);
    Route::get('admin/brand/data', [BrandController::class, 'getBrands']);
    Route::post('admin/brand/store', [BrandController::class, 'store']);
    Route::get('admin/brand/edit/{id}', [BrandController::class, 'edit']);
    Route::POST('admin/brand/update/{id}', [BrandController::class, 'update']);
    Route::delete('admin/brand/delete/{id}', [BrandController::class, 'destroy']);

    // measures
    Route::get('admin/measure/list', [MeasuresController::class, 'list']);
    Route::get('admin/measure/data', [MeasuresController::class, 'getMeasures']);
    Route::post('admin/measure/store', [MeasuresController::class, 'store']);
    Route::get('admin/measure/edit/{id}', [MeasuresController::class, 'edit']);
    Route::POST('admin/measure/update/{id}', [MeasuresController::class, 'update']);
    Route::delete('admin/measure/delete/{id}', [MeasuresController::class, 'destroy']);

    //taxes
    Route::get('admin/tax/list', [TaxesController::class, 'taxList']);
    Route::get('admin/tax/data', [TaxesController::class, 'getTaxes']);
    Route::post('admin/tax/store', [TaxesController::class, 'storeTax']);
    Route::get('admin/tax/edit/{id}', [TaxesController::class, 'editTax']);
    Route::POST('admin/tax/update/{id}', [TaxesController::class, 'updateTax']);
    Route::delete('admin/tax/delete/{id}', [TaxesController::class, 'destroyTax']);
    Route::get('admin/tax/{id}', [TaxesController::class, 'getTaxRate'])->name('admin.tax.rate');


    //product
    Route::get('admin/items/list', [ItemsController::class, 'productList'])->name('admin.items.list');
    Route::get('admin/items/data', [ItemsController::class, 'getProducts'])->name('product.fetch');
    Route::get('admin/items/create', [ItemsController::class, 'createProduct']);
    Route::post('admin/items/store', [ItemsController::class, 'store'])->name('items.store');
    Route::get('admin/items/edit/{id}', [ItemsController::class, 'edit']);
    Route::post('admin/items/update/{id}', [ItemsController::class, 'update']);
    Route::delete('admin/items/delete/{id}', [ItemsController::class, 'destroy']);

    Route::get('admin/items/{id}', [ItemsController::class, 'show']);
    Route::put('admin/items/toggle-status/{id}', [ItemsController::class, 'toggleStatus'])->name('admin.items.toggle-status');

    //  items by warehouse
    Route::get('admin/items/by_warehouse', [ItemsController::class, 'itemsByWarehouse'])->name('admin.items.by_warehouse');
    Route::get('admin/items/by_warehouse_simple', [ItemsController::class, 'itemsByWarehouseSimple'])->name('admin.items.by_warehouse_simple');
    Route::get('admin/items/get_item_by_warehouse', [ItemsController::class, 'getItemByWarehouse'])->name('admin.items.get_item_by_warehouse');
    Route::get('admin/items/search_products', [ItemsController::class, 'searchProducts'])->name('admin.items.search_products');
 // 
 
    Route::get('admin/items/get_subcategories/{category_id}', [ItemsController::class, 'getSubcategories'])->name('admin.items.get_subcategories');

    // buscar items traslado
    Route::get('admin/sales/search-items', [ItemsController::class, 'itemSearch'])->name('admin.items.search');
    Route::post('admin/items/check-barcode', [ItemsController::class, 'checkBarcode'])->name('admin.items.check-barcode');
    Route::post('admin/items/check-internal-code', [ItemsController::class, 'checkInternalCode'])->name('admin.items.check-internal-code');
    // lista de precios
    Route::get('admin/list_price/list', [ListPriceController::class, 'list'])->name('admin.list_price.list');
    Route::get('admin/list_price/data', [ListPriceController::class, 'getListPrices'])->name('admin.list_price.data');
    Route::post('admin/list_price/store', [ListPriceController::class, 'store'])->name('admin.list_price.store');
    Route::get('admin/list_price/edit/{id}', [ListPriceController::class, 'edit'])->name('admin.list_price.edit');
    Route::post('admin/list_price/update/{id}', [ListPriceController::class, 'update'])->name('admin.list_price.update');
    Route::delete('admin/list_price/delete/{id}', [ListPriceController::class, 'destroy'])->name('admin.list_price.delete');

    // orders
    Route::get('admin/orders/list', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::get('admin/orders/data', [OrderController::class, 'getOrders'])->name('admin.orders.fetch');
    Route::get('admin/orders/create', [OrderController::class, 'create'])->name('admin.orders.create');
    Route::post('admin/orders/store', [OrderController::class, 'store'])->name('admin.orders.store');
    Route::get('admin/orders/edit/{id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
    Route::post('admin/orders/update/{id}', [OrderController::class, 'update']);
    Route::delete('admin/orders/delete/{id}', [OrderController::class, 'destroy']);
    Route::get('admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');


    // items/search-items
    Route::get('admin/sales/search-items',  [InvoicesController::class, 'getItems'])->name('admin.items.search-items');
    //Route::get('admin/sales/fe')
    // data
    //Route::get('admin/sales/data',[SalesController::class, 'getSales']);


    // prevew
    Route::post('admin/sales/preview', [InvoicesController::class, 'preview']);
    Route::post('admin/sales/send-email/{id}', [InvoicesController::class, 'sendEmail'])->name('admin.sales.send-email');

    //tipo de identificacion
    Route::get('admin/identification_type/list', [IdentificationTypeController::class, 'list']);
    Route::get('admin/identification_type/data', [IdentificationTypeController::class, 'getTypeIdentities']);
    Route::post('admin/identification_type/store', [IdentificationTypeController::class, 'store']);
    Route::get('admin/identification_type/edit/{id}', [IdentificationTypeController::class, 'edit']);
    Route::post('admin/identification_type/update/{id}', [IdentificationTypeController::class, 'update']);
    Route::delete('admin/identification_type/delete/{id}', [IdentificationTypeController::class, 'destroy']);

    //departments
    Route::get('admin/department/list', [DepartmentsController::class, 'list']);
    Route::get('admin/department/data', [DepartmentsController::class, 'getDepartments']);
    Route::post('admin/department/store', [DepartmentsController::class, 'store']);
    Route::get('admin/department/edit/{id}', [DepartmentsController::class, 'edit']);
    Route::post('admin/department/update/{id}', [DepartmentsController::class, 'update']);
    Route::delete('admin/department/delete/{id}', [DepartmentsController::class, 'destroy']);


    //cities
    Route::get('admin/city/list', [CitysController::class, 'list']);
    Route::get('admin/city/data', [CitysController::class, 'getCities'])->name('city.fetch');
    Route::get('admin/city/create', [CitysController::class, 'createCity']);
    Route::post('admin/city/store', [CitysController::class, 'store'])->name('city.store');
    Route::get('admin/city/edit/{id}', [CitysController::class, 'edit']);
    Route::post('admin/city/update/{id}', [CitysController::class, 'update']);
    Route::delete('admin/city/delete/{id}', [CitysController::class, 'destroy']);
    Route::put('admin/city/toggle-status/{id}', [CitysController::class, 'toggleStatus'])->name('admin.city.toggle-status');

    // Plan Contable
    // Route::get('admin/account_plan/list',[AccountPlanController::class, 'list'])->name('admin.account_plan.list');
    // Route::get('admin/account_plan/data',[AccountPlanController::class, 'getDataAccounts'])->name('admin.account_plan.fetch');
    // Route::get('admin/account_plan/add',[AccountPlanController::class, 'addAccountPlan']);
    // Route::post('admin/account_plan/store',[AccountPlanController::class,'store'])->name('admin.account_plan.store');


    //contact ()
    Route::get('admin/contact/list', [ContactController::class, 'list']);
    Route::get('admin/contact/data', [ContactController::class, 'getContact'])->name('contact.fetch');
    Route::post('admin/contact/store', [ContactController::class, 'store'])->name('contact.store');
    Route::put('admin/contact/toggle-status/{id}', [ContactController::class, 'toggleStatus'])->name('admin.contact.toggle-status');
    Route::get('admin/contact/edit/{id}', [ContactController::class, 'edit'])->name('person.edit');
    Route::post('admin/contact/update/{id}', [ContactController::class, 'update']);
    Route::delete('admin/contact/delete/{id}', [ContactController::class, 'destroy']);
    Route::get('admin/contact/{id}', [ContactController::class, 'show']);

    // entidades Bancarias
    Route::get('admin/bank/list', [BankingInstitutionsController::class, 'list']);
    Route::get('admin/bank/data', [BankingInstitutionsController::class, 'getBanks'])->name('bank.fetch');
    Route::post('admin/bank/store', [BankingInstitutionsController::class, 'store'])->name('bank.store');
    Route::get('admin/bank/edit/{id}', [BankingInstitutionsController::class, 'edit']);
    Route::post('admin/bank/update/{id}', [BankingInstitutionsController::class, 'update']);
    Route::delete('admin/bank/delete/{id}', [BankingInstitutionsController::class, 'destroy']);
    Route::get('admin/bank/{id}', [BankingInstitutionsController::class, 'show']);

    // centro de costos
    Route::get('admin/cost_center/list', [CostCentersController::class, 'list']);
    Route::get('admin/cost_center/data', [CostCentersController::class, 'getCostCenters'])->name('cost_center.fetch');
    Route::post('admin/cost_center/store', [CostCentersController::class, 'store'])->name('cost_center.store');
    Route::get('admin/cost_center/edit/{id}', [CostCentersController::class, 'edit']);
    Route::post('admin/cost_center/update/{id}', [CostCentersController::class, 'update']);
    Route::delete('admin/cost_center/delete/{id}', [CostCentersController::class, 'destroy']);
    Route::get('admin/cost_center/{id}', [CostCentersController::class, 'show']);
    // cash
    Route::get('admin/cash_register/list', [CashRegisterController::class, 'list']);
    Route::get('admin/cash_register/data', [CashRegisterController::class, 'getCashRegisters'])->name('admin.cash_register.fetch');
    Route::post('admin/cash_register/store', [CashRegisterController::class, 'store'])->name('admin.cash_register.store');;

    // type_movement_cash
    Route::get('admin/type_movement_cash_register/list', [TypeMovementCashController::class, 'list']);
    Route::get('admin/type_movement_cash_register/data', [TypeMovementCashController::class, 'getMovementCategories'])->name('admin.type_movement_cash.fetch');
    Route::post(
        'admin/type_movement_cash_register/store',
        [TypeMovementCashController::class, 'store']
    )->name('admin.type_movement_cash.store');;
    Route::get('admin/type_movement_cash_register/edit/{id}', [TypeMovementCashController::class, 'edit']);
    Route::post('admin/type_movement_cash_register/update/{id}', [TypeMovementCashController::class, 'update']);
    Route::delete('admin/type_movement_cash_register/delete/{id}', [TypeMovementCashController::class, 'destroy']);
    Route::get('admin/type_movement_cash_register/{id}', [TypeMovementCashController::class, 'show']);
    // cash register
    Route::get('admin/cash_register_sessions/list', [CashRegisterSessionController::class, 'list'])->name('admin.cash_register_session.list');
    Route::post('admin/cash_register_session/open', [CashRegisterSessionController::class, 'open'])->name('admin.cash_register_session.open');
    Route::post('/admin/cash_register_session/close/{id}', [CashRegisterSessionController::class, 'close'])->name('admin.cash_register_session.close');
    Route::get('admin/cash_register_session/{id}', [CashRegisterSessionController::class, 'show'])->name('admin.cash_register_session.show');

    // movimientos de la caja
    Route::get('admin/cash_movements/list', [CashMovementController::class, 'list'])->name('admin.cash_movements.list');

    // configuracion empresa
    // Rutas para la gestión de la empresa
    Route::get('/admin/company', [CompaniesController::class, 'index'])->name('admin.companies.index');
    Route::put('/admin/company/{id}', [CompaniesController::class, 'update'])->name('admin.companies.update');

    // Rutas para obtener departamentos y ciudades
    Route::get('/admin/get-departments/{country}', [CompaniesController::class, 'getDepartments']);
    Route::get('/admin/get-cities/{department}', [CompaniesController::class, 'getCities']);



    // documentos contables
    Route::get('admin/account_document_type/list', [AccountingDocumentController::class, 'list']);
    Route::get('admin/account_document_type/data', [AccountingDocumentController::class, 'getDocumentTypes'])->name('document_type.fetch');
    Route::post('admin/account_document_type/store', [AccountingDocumentController::class, 'store'])->name('document_type.store');
    Route::get('admin/account_document_type/edit/{id}', [AccountingDocumentController::class, 'edit']);
    Route::post('admin/account_document_type/update/{id}', [AccountingDocumentController::class, 'update']);
    Route::delete('admin/account_document_type/delete/{id}', [AccountingDocumentController::class, 'destroy']);
    Route::get('admin/account_document_type/{id}', [AccountingDocumentController::class, 'show']);

    // fuentes contables
    Route::get('admin/account_document_source/list', [AccountDocumentSourceController::class, 'list']);
    Route::get('admin/account_document_source/data', [AccountDocumentSourceController::class, 'getFinancialSources'])->name('financial_source.fetch');
    Route::post('admin/account_document_source/store', [AccountDocumentSourceController::class, 'store'])->name('financial_source.store');
    Route::get('admin/account_document_source/edit/{id}', [AccountDocumentSourceController::class, 'edit']);
    Route::post('admin/account_document_source/update/{id}', [AccountDocumentSourceController::class, 'update']);
    Route::delete('admin/account_document_source/delete/{id}', [AccountDocumentSourceController::class, 'destroy']);
    Route::get('admin/account_document_source/{id}', [AccountDocumentSourceController::class, 'show']);

    // formas de pagos
    Route::get('admin/payment_type/list', [PaymentTypeController::class, 'list']);
    Route::get('admin/payment_type/data', [PaymentTypeController::class, 'getPaymentMethods'])->name('payment_method.fetch');
    Route::post('admin/payment_type/store', [PaymentTypeController::class, 'store'])->name('payment_method.store');
    Route::get('admin/payment_type/edit/{id}', [PaymentTypeController::class, 'edit']);
    Route::post('admin/payment_type/update/{id}', [PaymentTypeController::class, 'update']);
    Route::delete('admin/payment_type/delete/{id}', [PaymentTypeController::class, 'destroy']);
    Route::get('admin/payment_type/{id}', [PaymentTypeController::class, 'show']);

    //payment method
    Route::get('admin/payment_method/list', [PaymentMethodController::class, 'list']);
    Route::get('admin/payment_method/data', [PaymentMethodController::class, 'getPaymentMethods'])->name('payment_method.fetch');
    Route::post('admin/payment_method/store', [PaymentMethodController::class, 'store'])->name('payment_method.store');
    Route::get('admin/payment_method/edit/{id}', [PaymentMethodController::class, 'edit']);
    Route::post('admin/payment_method/update/{id}', [PaymentMethodController::class, 'update']);
    Route::delete('admin/payment_method/delete/{id}', [PaymentMethodController::class, 'destroy']);

    // cuentas por pagar
    Route::get('admin/accounts_payable/list', [AccountsPayableController::class, 'list']);
    Route::get('admin/accounts_payable/data', [AccountsPayableController::class, 'getAccountsPayable'])->name('admin.accounts_payable.fetch');

    Route::post('admin/payment_purchase/store', [PaymentsPurchasesController::class, 'store'])->name('admin.payment_purchases.payment');

    // datos de los pagos
    Route::get('admin/accounts_payable/{purchasePaymentId}/pdf', [AccountsPayableController::class, 'printPdf'])->name('payment_purchase.pdf');

    // Ruta para obtener detalles de pagos de una cuenta por pagar
    Route::get('admin/accounts_payable/{id}/details', [AccountsPayableController::class, 'getPaymentDetails'])->name('admin.accounts_payable.details');
    Route::get('admin/accounts_payable/{id}/pdf', [AccountsPayableController::class, 'printPdf'])->name('admin.accounts_payable.pdf');



    //Route::get('/admin/payment_purchase/pdf/{id}', [PaymentsPurchasesController::class, 'printPdf'])->name('admin.payment_purchase.pdf');

    //tipo items
    Route::get('admin/items_type/list', [ItemTypesController::class, 'list']);
    Route::get('admin/items_type/data', [ItemTypesController::class, 'getItemTypes'])->name('item_type.fetch');
    Route::post('admin/items_type/store', [ItemTypesController::class, 'store'])->name('item_type.store');
    Route::get('admin/items_type/edit/{id}', [ItemTypesController::class, 'edit']);
    Route::post('admin/items_type/update/{id}', [ItemTypesController::class, 'update']);
    Route::delete('admin/items_type/delete/{id}', [ItemTypesController::class, 'destroy']);
    Route::get('admin/items_type/{id}', [ItemTypesController::class, 'show']);
    // buscar item para añadir a compras

    //customers
    Route::get('admin/person/list', [PersonController::class, 'list'])->name('person.list');
    Route::get('admin/person/data', [PersonController::class, 'getCustomers'])->name('person.fetch');
    Route::post('admin/person/store', [PersonController::class, 'store'])->name('person.store');
    Route::get('admin/person/edit/{id}', [PersonController::class, 'edit']);
    Route::post('admin/person/update/{id}', [PersonController::class, 'update']);
    Route::delete('admin/person/delete/{id}', [PersonController::class, 'destroy']);
    Route::get('admin/person/{id}', [PersonController::class, 'show']);
    Route::get('admin/person/create', [PersonController::class, 'create']);
    Route::post('admin/person/check-email', [PersonController::class, 'checkEmail'])->name('admin.person.check-email');
    Route::put('admin/person/toggle-status/{id}', [PersonController::class, 'toggleStatus'])->name('admin.person.toggle-status');
    Route::get('admin/person/{id}', [PersonController::class, 'show']);
    Route::post(
        'admin/person/check-identification',
        [PersonController::class, 'checkIdentification']
    )->name('admin.person.check-identification');
    Route::get('admin/person/get_departments/{id}', [PersonController::class, 'getDepartmentsByCountry']);
    Route::get('admin/person/get_cities/{id}', [PersonController::class, 'getCitiesByDepartment']);

    Route::get('admin/person/get-details/{id}', [App\Http\Controllers\PersonController::class, 'getDetails']);
    // Store person via AJAX
    Route::post('admin/person/store-ajax', [App\Http\Controllers\PersonController::class, 'storeAjax']);
    // obtener los  person tipo cliente

    Route::get('admin/person/get-customers', [PersonController::class, 'getListPerson'])->name('admin.person.get-customers');

    // traslados entre bodegas
    Route::get('admin/transfer/list', [TransferController::class, 'list'])->name('transfer.list');
    Route::get('admin/transfer/create', [TransferController::class, 'create'])->name('admin.transfer.create');
    Route::get('admin/transfer/data', [TransferController::class, 'getTransfers'])->name('admin.transfer.fetch');
    Route::post('admin/transfer/store', [TransferController::class, 'store'])->name('admin.transfer.store');
    Route::get('admin/transfer/edit/{id}', [TransferController::class, 'edit']);
    Route::post('admin/transfer/update/{id}', [TransferController::class, 'update']);
    Route::delete('admin/transfer/delete/{id}', [TransferController::class, 'destroy']);
    //Route::get('admin/transfer/{id}', [TransferController::class,'show']);
    Route::get('admin/transfer/create', [TransferController::class, 'create']);
    // details
    Route::get('admin/transfer/{transferId}/details', [TransferController::class, 'getTransferDetails']);
    // Route::get('admin/transfer/{id}',[TransferController::class,'printPdf']);

    Route::get('admin/transfer/{transferId}/pdf', [TransferController::class, 'printPdf'])->name('transfer.print-pdf');


    Route::post('admin/transfer/update-status', [TransferController::class, 'updateStatus'])
        ->name('admin.transfer.update-status');

    Route::get('admin/transfer/export_pdf', [TransferController::class, 'exportPdf']);

    // account bank
    Route::get('admin/account_bank/list', [AccountBankController::class, 'list']);
    Route::get('admin/account_bank/data', [AccountBankController::class, 'getBankAccounts'])->name('bank_account.fetch');
    Route::post('admin/account_bank/store', [AccountBankController::class, 'store'])->name('bank_account.store');
    Route::get('admin/account_bank/edit/{id}', [AccountBankController::class, 'edit']);
    Route::post('admin/account_bank/update/{id}', [AccountBankController::class, 'update']);
    Route::delete('admin/account_bank/delete/{id}', [AccountBankController::class, 'destroy']);
    Route::get('admin/account_bank/{id}', [AccountBankController::class, 'show']);
    Route::post('admin/account_bank/check-number', [AccountBankController::class, 'checkNumber'])->name('admin.account_bank.check-number');

    // purchases2 - pruebas
    Route::get('admin/purchase/list', [Purchase2Controller::class, 'list'])->name('admin.purchase.list');
    Route::get('admin/purchase/data', [Purchase2Controller::class, 'getPurchases'])->name('admin.purchase.fetch');
    Route::get('admin/purchase/{id}/pdf', [Purchase2Controller::class, 'printPdf'])->name('admin.purchase.pdf');
    Route::get('admin/purchase/create', [Purchase2Controller::class, 'create']);
    Route::post('admin/purchase/store', [Purchase2Controller::class, 'store'])->name('admin.purchase.store');
    Route::get('admin/purchase/{id}', [Purchase2Controller::class, 'show']);
    Route::delete('admin/purchase/delete', [Purchase2Controller::class, 'destroy'])->name('admin.purchase.delete');
    Route::post('admin/purchase/update_state', [App\Http\Controllers\Purchase2Controller::class, 'updateState'])->name('admin.purchase.update_state');
    // ocompra desde la orden de compras 
    // Add this route for generating purchase from purchase order
    Route::post('admin/purchase/generate-from-order', [App\Http\Controllers\Purchase2Controller::class, 'generateFromOrder'])->name('admin.purchase.generate_from_order');
    // inventory
    Route::get('admin/inventory/list', [InventoryController::class, 'list']);
    //// Inventory routes
    Route::get('admin/inventory/list', [InventoryController::class, 'list'])->name('admin.inventory.list');
    Route::get('admin/inventory/fetch', [InventoryController::class, 'getInventory'])->name('admin.inventory.fetch');
    Route::post('admin/inventory/adjust', [InventoryController::class, 'adjustInventory'])->name('admin.inventory.adjust');
    Route::get('admin/inventory/history/{id}', [InventoryController::class, 'getInventoryHistory'])->name('admin.inventory.history');
    Route::get('admin/inventory/export/excel', [InventoryController::class, 'exportExcel'])->name('admin.inventory.export.excel');
    Route::get('admin/inventory/export/pdf', [InventoryController::class, 'exportPdf'])->name('admin.inventory.export.pdf');
    Route::get('admin/inventory/check-stock', [InventoryController::class, 'checkStock'])->name('admin.inventory.check-stock');

    // movements de los itemes
    Route::get('admin/movements/list', [App\Http\Controllers\ItemMovementController::class, 'list']);
    Route::get('admin/movements/fetch', [App\Http\Controllers\ItemMovementController::class, 'getMovements'])->name('admin.movements.fetch');
    Route::get('admin/kardex/detail/{id}', [App\Http\Controllers\ItemMovementController::class, 'getMovementDetail'])->name('admin.kardex.detail');

    // Supporting routes for filters
    Route::get('admin/warehouses/fetch', [App\Http\Controllers\WarehouseController::class, 'getWarehouses'])->name('admin.warehouses.fetch');
    Route::get('admin/categories/fetch', [App\Http\Controllers\CategoryController::class, 'getCategories'])->name('admin.categories.fetch');



    // order
    Route::get('admin/purchase_order/list', [PurchaseOrderController::class, 'list']);
    Route::get('admin/purchase_order/add', [PurchaseOrderController::class, 'add']);
    // edit
    Route::get('admin/purchase_order/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('admin.purchase_orders.edit');
    Route::get('admin/purchase_order/fetch', [PurchaseOrderController::class, 'getPurchaseOrders'])->name('admin.purchase_order.fetch');
    Route::get('admin/purchase_order/data', [PurchaseOrderController::class, 'getItems'])->name('admin.purchase_orders.get_items');
    //store
    Route::post('admin/purchase_order/store', [PurchaseOrderController::class, 'store'])->name('admin.purchase_orders.store');
    //show
    Route::get('admin/purchase_order/view/{id}', [PurchaseOrderController::class, 'viewOrder'])->name('admin.purchase_orders.view');
    Route::get('admin/purchase_order/export-pdf/{id}', [PurchaseOrderController::class, 'printPdf'])->name('admin.purchase_order.export.pdf');
    Route::get('admin/purchase_order/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('admin.purchase_order.edit');
    Route::post('admin/purchase_order/update_status/{id}', [PurchaseOrderController::class, 'updateStatus'])->name('admin.purchase_order.update_status');
    Route::get('admin/purchase_order/get-details/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'getDetails'])->name('admin.purchase_order.get_details');
    Route::post('admin/purchase_order/send-email', [App\Http\Controllers\PurchaseOrderController::class, 'sendEmail'])->name('admin.purchase_order.send_email');
    // create 
    // Route::get('admin/purchase_order/create',[PurchaseOrder2Controller::class, 'create']);

    // branch
    Route::get('admin/branch/list', [BranchController::class, 'list']);
    //store
    Route::post('admin/branch/store', [BranchController::class, 'store'])->name('admin.branch.store');
    //fecht
    Route::get('admin/branch/data', [BranchController::class, 'getBranches'])->name('admin.branch.fetch');
    //edit
    Route::get('admin/branch/edit/{id}', [BranchController::class, 'edit'])->name('admin.branch.edit');
    Route::post('admin/branch/update/{id}', [BranchController::class, 'update'])->name('admin.branch.update');
    Route::delete('admin/branch/delete/{id}', [BranchController::class, 'destroy'])->name('admin.branch.delete');
    Route::get('admin/branch/{id}', [BranchController::class, 'show'])->name('admin.branch.show');
    Route::put('admin/branch/toggle-status/{id}', [BranchController::class, 'toggleStatus'])->name('admin.branch.toggle_status');



    // status orden
    Route::get('admin/status_order/list', [OrderStatusController::class, 'list']);
    Route::get('admin/status_order/data', [OrderStatusController::class, 'getStatusOrders'])->name('admin.status_order.fetch');
    Route::post('admin/status_order/store', [OrderStatusController::class, 'store'])->name('admin.status_order.store');
    Route::get('admin/status_order/edit/{id}', [OrderStatusController::class, 'edit']);
    Route::post('admin/status_order/update/{id}', [OrderStatusController::class, 'update']);
    Route::delete('admin/status_order/delete/{id}', [OrderStatusController::class, 'destroy']);
    // sales
    Route::get('admin/sales/list', [InvoicesController::class, 'list'])->name('admin.sales.list');
    Route::get('admin/sales/data', [InvoicesController::class, 'getSales'])->name('admin.sales.fetch');
    Route::get('admin/sales/create', [InvoicesController::class, 'create']);
    Route::post('admin/sales/store', [InvoicesController::class, 'store'])->name('admin.sales.store');
    Route::get('admin/sales/view/{id}', [InvoicesController::class, 'view'])->name('admin.sales.view');
    Route::get('admin/sales/edit/{id}', [InvoicesController::class, 'edit'])->name('admin.sales.edit');
    Route::post('admin/sales/update/{id}', [InvoicesController::class, 'update'])->name('admin.sales.update');
    Route::delete('admin/sales/delete/{id}', [InvoicesController::class, 'destroy'])->name('admin.sales.destroy');

    Route::get('admin/sales/get-details/{id}', [InvoicesController::class, 'getDetails'])->name('admin.sales.get_details');



    //update_state
    Route::post('admin/sales/update_state', [InvoicesController::class, 'updateState'])->name('admin.sales.update_state');
    Route::get('admin/sales/{id}', [InvoicesController::class, 'show'])
        ->name('admin.sales.show');
    Route::get('admin/sales/{id}/pdf', [InvoicesController::class, 'printPdf'])->name('admin.sales.pdf');
    Route::get('admin/sales/export/pdf', [InvoicesController::class, 'exportPdf'])->name('admin.sales.export.pdf');
    Route::get('admin/sales/export/excel', [InvoicesController::class, 'exportExcel'])->name('admin.sales.export.excel');
    // sistema pos
    Route::get('admin/sales/listPos', [InvoicesController::class, 'listPos'])->name('admin.sales.pos');
    Route::get('/admin/reports/sales-by-category', [InvoicesController::class, 'salesByCategory'])->name('admin.reports.sales-by-category');
    // Professional POS System routes
    Route::get('admin/pos/dashboard', [InvoicesController::class, 'posDashboard'])->name('admin.pos.dashboard');
    Route::post('admin/pos/add-item', [InvoicesController::class, 'posAddItem'])->name('admin.pos.add_item');
    Route::post('admin/pos/remove-item', [InvoicesController::class, 'posRemoveItem'])->name('admin.pos.remove_item');
    Route::post('admin/pos/update-quantity', [InvoicesController::class, 'posUpdateQuantity'])->name('admin.pos.update_quantity');
    Route::post('admin/pos/apply-discount', [InvoicesController::class, 'posApplyDiscount'])->name('admin.pos.apply_discount');
    Route::post('admin/pos/process-payment', [InvoicesController::class, 'posProcessPayment'])->name('admin.pos.process_payment');
    Route::get('admin/pos/receipt/{id}', [InvoicesController::class, 'posReceipt'])->name('admin.pos.receipt');
    Route::post('admin/pos/update-quantity', [InvoicesController::class, 'posUpdateQuantity'])->name('admin.pos.update_quantity');
    Route::post('admin/pos/get-stock', [InvoicesController::class, 'getStock'])->name('admin.pos.get_stock');


    // cuentas por cobrar
    Route::get('admin/accounts_receivable/list', [AccountsReceivableController::class, 'list'])->name('admin.accounts_receivable.list');
    Route::get('admin/accounts_receivable/data', [AccountsReceivableController::class, 'getAccountsReceivable'])->name('admin.accounts_receivable.fetch');
    Route::get('admin/accounts_receivable/{id}/pdf', [AccountsReceivableController::class, 'printPdf'])->name('admin.accounts_receivable.pdf');
    Route::get('admin/accounts_receivable/{id}/ticket', [AccountsReceivableController::class, 'printPaymentTicket'])->name('admin.accounts_receivable.ticket');
    Route::post('admin/accounts_receivable/recalculate', [AccountsReceivableController::class, 'recalculateAllBalances'])->name('admin.accounts_receivable.recalculate');
    
    // pagos de cuentas por cobrar
    Route::post('admin/payment_receivables/store', [PaymentsSalesController::class, 'store'])->name('admin.payment_receivables.payment');
    Route::get('admin/payment_receivables/{id}/history', [PaymentsSalesController::class, 'getPaymentHistory'])->name('admin.payment_receivables.history');
    
    // Test route for debugging
    Route::get('admin/accounts_receivable/test', [AccountsReceivableController::class, 'testData'])->name('admin.accounts_receivable.test');
    Route::get('admin/accounts_receivable/simple', [AccountsReceivableController::class, 'getAccountsSimple'])->name('admin.accounts_receivable.simple');
    // metodos de pagos
    Route::get('admin/payment-method/list', [PaymentMethodController::class, 'list'])->name('admin.payment_method.list');
    Route::get('admin/payment-method/data', [PaymentMethodController::class, 'getPaymentMethods'])->name('admin.payment_methods.fetch');
    // movement_categories
    Route::get('admin/movement_categories/list', [MovementCategoryController::class, 'list'])->name('admin.movement_categories.list');
    Route::get('admin/movement_categories/data', [MovementCategoryController::class, 'getMovementCategories'])->name('admin.movement_categories.fetch');


    // ... existing code ...
    // purchase temp
    Route::post('admin/purchase/create/tmp', [PurchaseTempController::class, 'tmp_purchase'])->name('admin.purchase.tmp_purchase');

    Route::post('admin/purchase/update-discount', [App\Http\Controllers\PurchaseTempController::class, 'updateDiscount'])->name('admin.purchase.update_discount');
    Route::post('admin/purchase/update-cost_price', [App\Http\Controllers\PurchaseTempController::class, 'updateCostPrice'])->name('admin.purchase.update_cost_price');
    Route::post('admin/purchase/update-quantity', [App\Http\Controllers\PurchaseTempController::class, 'updateQuantity'])->name('admin.purchase.update_quantity');

    Route::delete('admin/purchase/create/tmp/{id}', [PurchaseTempController::class, 'destroy'])->name('admin.purchase.tmp_purchase.destroy');
    //contabilidad
    Route::get('admin/accounting_type/list', [AccountingAccountTypeController::class, 'list']);
    Route::get('admin/accounting_type/data', [AccountingAccountTypeController::class, 'getAccountingAccountTypes'])->name('admin.account_type.get_account_types');

    // cuentas contables
    
    //quotations
    Route::get('admin/quotation/list', [QuotationController::class, 'list'])->name('admin.quotation.list');
    Route::get('admin/quotation/data', [QuotationController::class, 'getQuotations'])->name('admin.quotation.fetch');
    Route::get('admin/quotation/create', [QuotationController::class, 'create']);
    Route::get('admin/quotation/{id}', [QuotationController::class, 'show'])->name('admin.quotation.show');
    Route::post('admin/quotation/store', [QuotationController::class, 'store'])->name('admin.quotation.store');
    Route::get('admin/quotation/edit/{id}', [QuotationController::class, 'edit']);
    Route::post('admin/quotation/update/{id}', [QuotationController::class, 'update']);
    Route::delete('admin/quotation/delete/{id}', [QuotationController::class, 'destroy']);
    //Route::get('admin/quotation/get-details/{id}', [App\Http\Controllers\QuotationController::class, 'getDetails'])->name('admin.quotation.get_details');
    Route::get('admin/quotation/details/{id}', [QuotationController::class, 'getDetails'])->name('admin.quotation.details');
    Route::post('admin/quotation/send-email', [QuotationController::class, 'sendEmail'])->name('admin.quotation.send_email');
    Route::get('admin/quotation/pdf/{id}', [QuotationController::class, 'pdfQuotation'])->name('admin.quotation.pdf');
    Route::post('admin/quotation/destroy/{id}', [QuotationController::class, 'destroy'])->name('admin.quotation.destroy');
    Route::post('admin/quotation/approve/{id}', [QuotationController::class, 'approve'])->name('admin.quotation.approve');
    //Route::post('admin/quotation/update_state', [QuotationController::class, 'updateState'])->name('admin.quotation.update_state');
    Route::post('admin/quotation/update-state', [QuotationController::class, 'updateState'])->name('admin.quotation.update_state');
    Route::post('admin/quotation/convert-to-sale', [QuotationController::class, 'convertToSale'])->name('admin.quotation.convert_to_sale');



    // asset_category
    Route::get('admin/asset_category/list', [AssetCategoryController::class, 'list'])->name('admin.asset_category.list');
    Route::get('admin/asset_category/data', [AssetCategoryController::class, 'getAssetCategories'])->name('admin.asset_category.fetch');
    Route::post('admin/asset_category/store', [AssetCategoryController::class, 'store'])->name('admin.asset_category.store');
    Route::get('admin/asset_category/edit/{id}', [AssetCategoryController::class, 'edit']);
    Route::post('admin/asset_category/update/{id}', [AssetCategoryController::class, 'update']);
    Route::delete('admin/asset_category/delete/{id}', [AssetCategoryController::class, 'destroy']);
    // asset_locacion
    Route::get('admin/asset_location/list', [AssetLocationController::class, 'list'])->name('admin.asset_location.list');
    Route::get('admin/asset_location/data', [AssetLocationController::class, 'getAssetLocations'])->name('admin.asset_location.fetch');
    Route::post('admin/asset_location/store', [AssetLocationController::class, 'store'])->name('admin.asset_location.store');
    Route::get('admin/asset_location/edit/{id}', [AssetLocationController::class, 'edit']);
    Route::post('admin/asset_location/update/{id}', [AssetLocationController::class, 'update']);
    Route::delete('admin/asset_location/delete/{id}', [AssetLocationController::class, 'destroy']);


    //type_regimen
    Route::get('admin/type_regimen/list', [TypeRegimenController::class, 'list']);
    Route::get('admin/type_regimen/data', [TypeRegimenController::class, 'getTypeLiabilities'])->name('type_regimen.fetch');
    Route::post('admin/type_regimen/store', [TypeRegimenController::class, 'store'])->name('type_regimen.store');
    Route::get('admin/type_regimen/edit/{id}', [TypeRegimenController::class, 'edit']);
    Route::post('admin/type_regimen/update/{id}', [TypeRegimenController::class, 'update']);
    Route::delete('admin/type_regimen/delete/{id}', [TypeRegimenController::class, 'destroy']);
    Route::put('admin/type_regimen/toggle-status/{id}', [TypeRegimenController::class, 'toggleStatus'])->name('admin.type_regimen.toggle-status');

    //type_liability
    Route::get('admin/type_liability/list', [TypeLiabilityController::class, 'list']);
    Route::get('admin/type_liability/data', [TypeLiabilityController::class, 'getTypeLiabilities'])->name('type_liability.fetch');
    Route::post('admin/type_liability/store', [TypeLiabilityController::class, 'store'])->name('type_liability.store');
    Route::get('admin/type_liability/edit/{id}', [TypeLiabilityController::class, 'edit']);
    Route::post('admin/type_liability/update/{id}', [TypeLiabilityController::class, 'update']);
    Route::delete('admin/type_liability/delete/{id}', [TypeLiabilityController::class, 'destroy']);




    // send  email
    Route::get('admin/communicate/send_email', [CommunicateController::class, 'SendEmail']);
    Route::post('admin/communicate/send_email_store', [CommunicateController::class, 'SendEmailStore'])->name('admin.email.store');


    // colors
    Route::get('admin/colors/list', [ColorsController::class, 'index']);
    Route::get('admin/colors/data', [ColorsController::class, 'getColorList'])->name('colors.fetch');
    Route::post('admin/colors/store', [ColorsController::class, 'store'])->name('colors.store');
    Route::get('admin/colors/edit/{id}', [ColorsController::class, 'edit']);
    Route::post('admin/colors/update/{id}', [ColorsController::class, 'update']);
    Route::delete('admin/colors/delete/{id}', [ColorsController::class, 'destroy']);
    Route::get('admin/colors/{id}', [ColorsController::class, 'show']);

    // dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/dashboard/totales', [DashboardController::class, 'getTotales'])->name('dashboard.totales');
    Route::get('admin/dashboard/test-models', [DashboardController::class, 'testModels'])->name('dashboard.test');

   
    Route::get('admin/notes_concept/list', [NotesConceptController::class, 'list'])->name('admin.notes_concept.list');
    Route::get('admin/notes_concept/data', [NotesConceptController::class, 'getNotesConcepts'])->name('admin.notes_concept.fetch');
    Route::post('admin/notes_concept/store', [NotesConceptController::class, 'store'])->name('admin.notes_concept.store');
    Route::get('admin/notes_concept/edit/{id}', [NotesConceptController::class, 'edit'])->name('admin.notes_concept.edit');
    Route::post('admin/notes_concept/update/{id}', [NotesConceptController::class, 'update'])->name('admin.notes_concept.update');
    Route::delete('admin/notes_concept/delete/{id}', [NotesConceptController::class, 'destroy'])->name('admin.notes_concept.delete');

    // backup
    Route::get('admin/backups/list', [BackupController::class, 'index'])->name('admin.backups.list');
    Route::get('admin/backups/create', [BackupController::class, 'create'])->name('admin.backups.create');
    Route::post('admin/backups/store', [BackupController::class, 'store'])->name('admin.backups.store');
    Route::post('admin/backups/destroy', [BackupController::class, 'destroy'])->name('admin.backups.destroy');
    Route::get('admin/backups/download/{fileName}', [BackupController::class, 'download'])->name('admin.backups.download');
    Route::delete('admin/backups/delete/{fileName}', [BackupController::class, 'destroy'])->name('admin.backups.delete');

    // notes_credit_debit
    Route::get('admin/notes_credit_debit/list', [NotesCreditDebitController::class, 'list'])->name('admin.notes_credit_debit.list');


    // adjustment_reason
    Route::get('admin/adjustment_reason/list', [AdjustmentReasonController::class, 'list'])->name('admin.adjustment_reason.list');
    Route::get('admin/adjustment_reason/data', [AdjustmentReasonController::class, 'getAdjustmentReasons'])->name('admin.adjustment_reason.fetch');
    Route::post('admin/adjustment_reason/store', [AdjustmentReasonController::class, 'store'])->name('admin.adjustment_reason.store');
    Route::get('admin/adjustment_reason/edit/{id}', [AdjustmentReasonController::class, 'edit'])->name('admin.adjustment_reason.edit');
    Route::post('admin/adjustment_reason/update/{id}', [AdjustmentReasonController::class, 'update'])->name('admin.adjustment_reason.update');
    Route::delete('admin/adjustment_reason/delete/{id}', [AdjustmentReasonController::class, 'destroy'])->name('admin.adjustment_reason.delete');

    // inventory_ajusts
    Route::get('admin/inventory_ajusts/list', [InventoryAjustmentController::class, 'list'])->name('admin.inventory_ajusts.list');
    Route::get('admin/inventory_ajusts/data', [InventoryAjustmentController::class, 'getInventoryAjusts'])->name('admin.inventory_ajusts.fetch');
    Route::get('admin/inventory_ajusts/create', [InventoryAjustmentController::class, 'create'])->name('admin.inventory_ajusts.create');
    Route::post('admin/inventory_ajusts/store', [InventoryAjustmentController::class, 'store'])->name('admin.inventory_ajusts.store');
    Route::get('admin/inventory_ajusts/show/{id}', [InventoryAjustmentController::class, 'show'])->name('admin.inventory_ajusts.show');
    Route::get('admin/inventory_ajusts/edit/{id}', [InventoryAjustmentController::class, 'edit'])->name('admin.inventory_ajusts.edit');
    Route::post('admin/inventory_ajusts/update/{id}', [InventoryAjustmentController::class, 'update'])->name('admin.inventory_ajusts.update');
    Route::delete('admin/inventory_ajusts/delete/{id}', [InventoryAjustmentController::class, 'destroy'])->name('admin.inventory_ajusts.delete');
    Route::get('admin/inventory_ajusts/excel', [InventoryAjustmentController::class, 'exportExcel'])->name('admin.inventory_ajusts.export.excel');
    Route::get('admin/inventory_ajusts/pdf', [InventoryAjustmentController::class, 'exportPdf'])->name('admin.inventory_ajusts.export.pdf');
    Route::get('admin/inventory_ajusts/csv', [InventoryAjustmentController::class, 'exportCsv'])->name('admin.inventory_ajusts.export.csv');
    Route::post('admin/inventory_ajusts/approve/{id}', [InventoryAjustmentController::class, 'approve'])->name('admin.inventory_ajusts.approve');
    Route::post('admin/inventory_ajusts/update_status/{id}', [InventoryAjustmentController::class, 'updateStatus'])->name('admin.inventory_ajusts.update_status');
    Route::get('admin/inventory_ajusts/pdf/{id}', [InventoryAjustmentController::class, 'printPdf'])->name('admin.inventory_ajusts.pdf');

    Route::get('admin/inventory_ajusts/get_items_with_cache', [InventoryAjustmentController::class, 'getItemsWithCache'])->name('admin.inventory_ajusts.get_items_with_cache');



    Route::post('admin/inventory_ajusts/bulk_delete', [InventoryAjustmentController::class, 'bulkDelete'])->name('admin.inventory_ajusts.bulk_delete');
    Route::post('admin/inventory_ajusts/bulk_approve', [InventoryAjustmentController::class, 'bulkApprove'])->name('admin.inventory_ajusts.bulk_approve');
    Route::post('admin/inventory_ajusts/destroy', [InventoryAjustmentController::class, 'destroy'])->name('admin.inventory_ajusts.destroy');

    // Additional routes for filter options
    Route::get('admin/warehouses/all', [WarehouseController::class, 'getAllWarehouses'])->name('admin.warehouses.all');
    //Route::get('admin/adjustment_types/all', [AdjustmentTypeController::class, 'getAllAdjustmentTypes'])->name('admin.adjustment_types.all');
    Route::get('admin/adjustment_reasons/all', [AdjustmentReasonController::class, 'getAllAdjustmentReasons'])->name('admin.adjustment_reasons.all');
    // Route::get('admin/users/all', [UserController::class, 'getAllUsers'])->name('admin.users.all');

 // receipt_types
    Route::get('admin/receipt_types/list', [ReceiptTypeController::class, 'list'])->name('admin.receipt_types.list');
    Route::get('admin/receipt_types/data', [ReceiptTypeController::class, 'getReceiptTypes'])->name('admin.receipt_types.fetch');
    Route::post('admin/receipt_types/store', [ReceiptTypeController::class, 'store'])->name('admin.receipt_types.store');
    Route::get('admin/receipt_types/edit/{id}', [ReceiptTypeController::class, 'edit'])->name('admin.receipt_types.edit');
    Route::post('admin/receipt_types/update/{id}', [ReceiptTypeController::class, 'update'])->name('admin.receipt_types.update');
    Route::delete('admin/receipt_types/delete/{id}', [ReceiptTypeController::class, 'destroy'])->name('admin.receipt_types.delete');

    // account_movements
    Route::get('admin/account_movements/list', [AccountingMovementController::class, 'list'])->name('admin.account_movements.list');
    Route::get('admin/account_movements/data', [AccountingMovementController::class, 'getAccountMovements'])->name('admin.account_movements.fetch');

    // tipo sucursales
    Route::get('admin/branch_type/list', [BranchTypeController::class, 'list'])->name('admin.branch_type.list');
    Route::get('admin/branch_type/data', [BranchTypeController::class, 'getBranchTypes'])->name('admin.branch_type.fetch');
    Route::post('admin/branch_type/store', [BranchTypeController::class, 'store'])->name('admin.branch_type.store');
    Route::get('admin/branch_type/edit/{id}', [BranchTypeController::class, 'edit'])->name('admin.branch_type.edit');
    Route::post('admin/branch_type/update/{id}', [BranchTypeController::class, 'update'])->name('admin.branch_type.update');
    Route::delete('admin/branch_type/delete/{id}', [BranchTypeController::class, 'destroy'])->name('admin.branch_type.delete');
    Route::put('admin/branch_type/toggle-status/{id}', [BranchTypeController::class, 'toggleStatus'])->name('admin.branch_type.toggle-status');

 
});

Route::group(['middleware' => 'user'], function () {
    Route::get('user/dashboard', [DashboardController::class, 'dashboard']);
    // rutas para ventas de usuarios
    Route::get('user/sales/list', [UserSalesController::class, 'list'])->name('user.sales.list');
    Route::get('user/sales/create', [UserSalesController::class, 'create'])->name('user.sales.create');
    Route::post('user/sales/store', [UserSalesController::class, 'store'])->name('user.sales.store');
    Route::get('user/sales/{id}', [UserSalesController::class, 'show'])->name('user.sales.show');
});

Route::group(['middleware' => 'super'], function () {
    Route::get('super/dashboard', [SuperAdminController::class, 'dashboard'])->name('super.dashboard');
    
    // User management routes
    Route::get('super/users', [SuperAdminController::class, 'users'])->name('super.users.list');
    Route::get('super/users/data', [SuperAdminController::class, 'getUsersData'])->name('super.users.data');
    Route::get('super/users/create-super-admin', [SuperAdminController::class, 'createSuperAdmin'])->name('super.users.create_super_admin');
    Route::post('super/users/store-super-admin', [SuperAdminController::class, 'storeSuperAdmin'])->name('super.users.store_super_admin');
    Route::get('super/users/{id}/edit', [SuperAdminController::class, 'editUser'])->name('super.users.edit');
    Route::put('super/users/{id}', [SuperAdminController::class, 'updateUser'])->name('super.users.update');
    Route::delete('super/users/{id}', [SuperAdminController::class, 'deleteUser'])->name('super.users.delete');
    Route::post('super/users/{id}/toggle-status', [SuperAdminController::class, 'toggleUserStatus'])->name('super.users.toggle_status');
});


Route::get('logout', [AuthController::class, 'logout']);

// Route for creating the first super admin (initial setup)
Route::match(['get', 'post'], 'setup/first-super-admin', [SuperAdminController::class, 'createFirstSuperAdmin'])->name('setup.first_super_admin');


// // Cash Register routes
// Route::get('admin/cash_register/list', [App\Http\Controllers\CashRegisterController::class, 'list'])->name('admin.cash_register.list');
// Route::get('admin/cash_register/data', [App\Http\Controllers\CashRegisterController::class, 'getCashRegisters'])->name('admin.cash_register.fetch');
// Route::post('admin/cash_register/open', [App\Http\Controllers\CashRegisterController::class, 'openRegister'])->name('admin.cash_register.open');
// Route::post('admin/cash_register/close/{id}', [App\Http\Controllers\CashRegisterController::class, 'closeRegister'])->name('admin.cash_register.close');
// Route::get('admin/cash_register/{id}/movements', [App\Http\Controllers\CashRegisterController::class, 'getMovements'])->name('admin.cash_register.movements');
// Route::get('admin/cash_register/{id}/report', [App\Http\Controllers\CashRegisterController::class, 'generateReport'])->name('admin.cash_register.report');

Route::middleware(['auth'])->group(function () {
    // ... existing routes ...

    // Dashboard routes

});
    // PUC Accounts (Plan Único de Cuentas)
    Route::resource('admin/puc-accounts', App\Http\Controllers\PucAccountController::class, [
        'names' => [
            'index' => 'puc-accounts.index',
            'create' => 'puc-accounts.create',
            'store' => 'puc-accounts.store',
            'show' => 'puc-accounts.show',
            'edit' => 'puc-accounts.edit',
            'update' => 'puc-accounts.update',
            'destroy' => 'puc-accounts.destroy'
        ]
    ]);
    
    // Additional PUC Account routes
    Route::patch('admin/puc-accounts/{pucAccount}/toggle-status', [App\Http\Controllers\PucAccountController::class, 'toggleStatus'])
        ->name('puc-accounts.toggle-status');
    Route::get('admin/puc-accounts/api/by-parent', [App\Http\Controllers\PucAccountController::class, 'getAccountsByParent'])
        ->name('puc-accounts.by-parent');
    Route::get('admin/puc-accounts/api/movement-accounts', [App\Http\Controllers\PucAccountController::class, 'getMovementAccounts'])
        ->name('puc-accounts.movement-accounts'); 
   // Accounting Movements (Comprobantes Contables)
 
    
   