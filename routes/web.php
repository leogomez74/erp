<?php

use App\Models\Utility;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::get('/', 'HomeController@index')->name('home')->middleware(['XSS']);
Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', 'XSS']);

Route::get('/register/{lang?}', 'Auth\RegisteredUserController@showRegistrationForm')->name('register');
//Route::get('/register/{lang?}', function () {
//    $settings = Utility::settings();
//    $lang = $settings['default_language'];
//
//    if($settings['enable_signup'] == 'on'){
//        return view("auth.register", compact('lang'));
//       // Route::get('/register', 'Auth\RegisteredUserController@showRegistrationForm')->name('register');
//    }else{
//        return Redirect::to('login');
//    }
//
//});

Route::post('register', 'Auth\RegisteredUserController@store')->name('register');

Route::get('/login/{lang?}', 'Auth\AuthenticatedSessionController@showLoginForm')->name('login');

// Route::get('/password/resets/{lang?}', 'Auth\AuthenticatedSessionController@showLinkRequestForm')->name('change.langPass');
// Route::get('/password/resets/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('change.langPass');

Route::get('/', 'DashboardController@account_dashboard_index')->name('dashboard')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);

Route::get('/account-dashboard', 'DashboardController@account_dashboard_index')->name('dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/project-dashboard', 'DashboardController@project_dashboard_index')->name('project.dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('/hrm-dashboard', 'DashboardController@hrm_dashboard_index')->name('hrm.dashboard')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::post('edit-profile', 'UserController@editprofile')->name('update.account')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
        'permissions',
    ]
);
Route::post('change-password', 'UserController@updatePassword')->name('update.password');
Route::any('user-reset-password/{id}', 'UserController@userPassword')->name('users.reset');
Route::post('user-reset-password/{id}', 'UserController@userPasswordReset')->name('user.password.update');

Route::get(
    '/change/mode', 'UserController@changeMode')->name('change.mode');

Route::resource('roles', 'RoleController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('permissions', 'PermissionController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('change-language/{lang}', 'LanguageController@changeLanquage')->name('change.language');
        Route::get('change-company/{company}', 'CompanyController@chanceCompany')->name('change.company');

        Route::get('manage-language/{lang}', 'LanguageController@manageLanguage')->name('manage.language');
        Route::post('store-language-data/{lang}', 'LanguageController@storeLanguageData')->name('store.language.data');
        Route::get('create-language', 'LanguageController@createLanguage')->name('create.language');
        Route::post('store-language', 'LanguageController@storeLanguage')->name('store.language');

        Route::delete('/lang/{lang}', 'LanguageController@destroyLang')->name('lang.destroy');
    }
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::resource('systems', 'SystemController');
        Route::post('email-settings', 'SystemController@saveEmailSettings')->name('email.settings');
        Route::post('company-settings', 'SystemController@saveCompanySettings')->name('company.settings');
        Route::post('system-settings', 'SystemController@saveSystemSettings')->name('system.settings');
        Route::post('zoom-settings', 'SystemController@saveZoomSettings')->name('zoom.settings');
        Route::post('slack-settings', 'SystemController@saveSlackSettings')->name('slack.settings');
        Route::post('telegram-settings', 'SystemController@saveTelegramSettings')->name('telegram.settings');
        Route::post('twilio-setting', 'SystemController@saveTwilioSettings')->name('twilio.setting');

        Route::get('print-setting', 'SystemController@printIndex')->name('print.setting');
        Route::get('company-setting', 'SystemController@companyIndex')->name('company.setting');
        Route::post('business-setting', 'SystemController@saveBusinessSettings')->name('business.setting');
        Route::post('company-payment-setting', 'SystemController@saveCompanyPaymentSettings')->name('company.payment.settings');
        Route::get('test-mail', 'SystemController@testMail')->name('test.mail');
        Route::post('test-mail', 'SystemController@testSendMail')->name('test.send.mail');
        Route::post('stripe-settings', 'SystemController@savePaymentSettings')->name('payment.settings');
        Route::post('pusher-setting', 'SystemController@savePusherSettings')->name('pusher.setting');
        Route::post('recaptcha-settings', 'SystemController@recaptchaSettingStore')->name('recaptcha.settings.store')->middleware(['auth', 'XSS']);
    }
);

Route::get('productservice/index', 'ProductServiceController@index')->name('productservice.index');
Route::resource('productservice', 'ProductServiceController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//Product Stock
Route::resource('productstock', 'ProductStockController')->middleware(
    [
        'auth',
        'XSS', 'revalidate',
    ]
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('customer/{id}/show', 'CustomerController@show')->name('customer.show');
        Route::resource('customer', 'CustomerController');
    }
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('vender/{id}/show', 'VenderController@show')->name('vender.show');
        Route::resource('vender', 'VenderController');
    }
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::resource('bank-account', 'BankAccountController');
    }
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('bank-transfer/index', 'BankTransferController@index')->name('bank-transfer.index');
        Route::resource('bank-transfer', 'BankTransferController');
    }
);

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('currencies', 'CurrenciesController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('product-category', 'ProductServiceCategoryController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('product-unit', 'ProductServiceUnitController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('invoice/pdf/{id}', 'InvoiceController@invoice')->name('invoice.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('invoice/{id}/duplicate', 'InvoiceController@duplicate')->name('invoice.duplicate');
        Route::get('invoice/{id}/shipping/print', 'InvoiceController@shippingDisplay')->name('invoice.shipping.print');
        Route::get('invoice/{id}/payment/reminder', 'InvoiceController@paymentReminder')->name('invoice.payment.reminder');
        Route::get('invoice/index', 'InvoiceController@index')->name('invoice.index');
        Route::post('invoice/product/destroy', 'InvoiceController@productDestroy')->name('invoice.product.destroy');
        Route::post('invoice/product', 'InvoiceController@product')->name('invoice.product');
        Route::post('invoice/customer', 'InvoiceController@customer')->name('invoice.customer');
        Route::get('invoice/customer{id}', 'InvoiceController@customer2')->name('invoice.customer2');
        Route::get('invoice/{id}/sent', 'InvoiceController@sent')->name('invoice.sent');
        //Route created by ahixel rojas at 22/09/2022 17:30 to activate markSent function in The invoiceController
        Route::get('invoice/{id}/mark-sent', 'InvoiceController@markSent')->name('invoice.mark-sent');
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        Route::get('invoice/{id}/resent', 'InvoiceController@resent')->name('invoice.resent');
        Route::get('invoice/{id}/payment', 'InvoiceController@payment')->name('invoice.payment');
        Route::post('invoice/{id}/payment', 'InvoiceController@createPayment')->name('invoice.payment');
        Route::post('invoice/{id}/payment/{pid}/destroy', 'InvoiceController@paymentDestroy')->name('invoice.payment.destroy');
        Route::get('invoice/items', 'InvoiceController@items')->name('invoice.items');

        Route::resource('invoice', 'InvoiceController');
        Route::get('invoice/create/{cid}', 'InvoiceController@create')->name('invoice.create');
    }
);

Route::get(
    '/invoices/preview/{template}/{color}', 'InvoiceController@previewInvoice')->name('invoice.preview');
Route::post(
    '/invoices/template/setting', 'InvoiceController@saveTemplateSettings')->name('template.setting');

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('credit-note', 'CreditNoteController@index')->name('credit.note');
        Route::get('custom-credit-note', 'CreditNoteController@customCreate')->name('invoice.custom.credit.note');
        Route::post('custom-credit-note', 'CreditNoteController@customStore')->name('invoice.custom.credit.note');
        Route::get('credit-note/invoice', 'CreditNoteController@getinvoice')->name('invoice.get');
        Route::get('invoice/{id}/credit-note', 'CreditNoteController@create')->name('invoice.credit.note');
        Route::post('invoice/{id}/credit-note', 'CreditNoteController@store')->name('invoice.credit.note');
        Route::get('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@edit')->name('invoice.edit.credit.note');
        Route::post('invoice/{id}/credit-note/edit/{cn_id}', 'CreditNoteController@update')->name('invoice.edit.credit.note');
        Route::delete('invoice/{id}/credit-note/delete/{cn_id}', 'CreditNoteController@destroy')->name('invoice.delete.credit.note');
    }
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('debit-note', 'DebitNoteController@index')->name('debit.note');
        Route::get('custom-debit-note', 'DebitNoteController@customCreate')->name('bill.custom.debit.note');
        Route::post('custom-debit-note', 'DebitNoteController@customStore')->name('bill.custom.debit.note');
        Route::get('debit-note/bill', 'DebitNoteController@getbill')->name('bill.get');
        Route::get('bill/{id}/debit-note', 'DebitNoteController@create')->name('bill.debit.note');
        Route::post('bill/{id}/debit-note', 'DebitNoteController@store')->name('bill.debit.note');
        Route::get('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@edit')->name('bill.edit.debit.note');
        Route::post('bill/{id}/debit-note/edit/{cn_id}', 'DebitNoteController@update')->name('bill.edit.debit.note');
        Route::delete('bill/{id}/debit-note/delete/{cn_id}', 'DebitNoteController@destroy')->name('bill.delete.debit.note');
    }
);

Route::get(
    '/bill/preview/{template}/{color}', 'BillController@previewBill')->name('bill.preview');
Route::post(
    '/bill/template/setting', 'BillController@saveBillTemplateSettings')->name('bill.template.setting');

Route::resource('taxes', 'TaxController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('revenue/index', 'RevenueController@index')->name('revenue.index')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('revenue', 'RevenueController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('bill/pdf/{id}', 'BillController@bill')->name('bill.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('bill/{id}/duplicate', 'BillController@duplicate')->name('bill.duplicate');
        Route::get('bill/{id}/shipping/print', 'BillController@shippingDisplay')->name('bill.shipping.print');
        Route::get('bill/index', 'BillController@index')->name('bill.index');
        Route::post('bill/product/destroy', 'BillController@productDestroy')->name('bill.product.destroy');
        Route::post('bill/product', 'BillController@product')->name('bill.product');
        Route::post('bill/vender', 'BillController@vender')->name('bill.vender');
        Route::get('bill/{id}/sent', 'BillController@sent')->name('bill.sent');
        Route::get('bill/{id}/resent', 'BillController@resent')->name('bill.resent');
        Route::get('bill/{id}/payment', 'BillController@payment')->name('bill.payment');
        Route::post('bill/{id}/payment', 'BillController@createPayment')->name('bill.payment');
        Route::post('bill/{id}/payment/{pid}/destroy', 'BillController@paymentDestroy')->name('bill.payment.destroy');
        Route::get('bill/items', 'BillController@items')->name('bill.items');

        Route::resource('bill', 'BillController');
        Route::get('bill/create/{cid}', 'BillController@create')->name('bill.create');
    }
);

Route::get('payment/index', 'PaymentController@index')->name('payment.index')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('payment', 'PaymentController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('report/transaction', 'TransactionController@index')->name('transaction.index');
    }
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('report/account', 'ReportController@Account')->name('report.account');
        Route::get('report/account2', 'ReportController@Account2')->name('report.account2');

        Route::get('report/income-summary', 'ReportController@incomeSummary')->name('report.income.summary');
        Route::get('report/expense-summary', 'ReportController@expenseSummary')->name('report.expense.summary');
        Route::get('report/income-vs-expense-summary', 'ReportController@incomeVsExpenseSummary')->name('report.income.vs.expense.summary');
        Route::get('report/tax-summary', 'ReportController@taxSummary')->name('report.tax.summary');
        Route::get('report/profit-loss-summary', 'ReportController@profitLossSummary')->name('report.profit.loss.summary');
        Route::get('report/profit_loss_total', 'ReportController@profitLossTotal')->name('report.profit.loss.total');

        Route::get('report/invoice-summary', 'ReportController@invoiceSummary')->name('report.invoice.summary');
        Route::get('report/accounts', 'ReportController@account')->name('report.accounts');

        Route::get('report/bill-summary', 'ReportController@billSummary')->name('report.bill.summary');
        Route::get('report/product-stock-report', 'ReportController@productStock')->name('report.product.stock.report');

        Route::get('report/invoice-report', 'ReportController@invoiceReport')->name('report.invoice');
        Route::get('report/account-statement-report', 'ReportController@accountStatement')->name('report.account.statement');

        Route::get('report/balance-sheet', 'ReportController@balanceSheet')->name('report.balance.sheet');
        Route::get('report/ledger', 'ReportController@ledgerSummary')->name('report.ledger');
        Route::get('report/trial-balance', 'ReportController@trialBalanceSummary')->name('trial.balance');

        /* WILMER MARQUEZ */
        Route::get('report/accountbalances', [App\Http\Livewire\Components\Accountbalances::class, '__invoke'])->name('report.accountbalances');
    }
);

Route::get('proposal/pdf/{id}', 'ProposalController@proposal')->name('proposal.pdf')->middleware(
    [
        'XSS',
        'revalidate',
    ]
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('proposal/{id}/status/change', 'ProposalController@statusChange')->name('proposal.status.change');
        Route::get('proposal/{id}/convert', 'ProposalController@convert')->name('proposal.convert');
        Route::get('proposal/{id}/duplicate', 'ProposalController@duplicate')->name('proposal.duplicate');
        Route::post('proposal/product/destroy', 'ProposalController@productDestroy')->name('proposal.product.destroy');
        Route::post('proposal/customer', 'ProposalController@customer')->name('proposal.customer');
        Route::post('proposal/product', 'ProposalController@product')->name('proposal.product');
        Route::get('proposal/items', 'ProposalController@items')->name('proposal.items');
        Route::get('proposal/{id}/sent', 'ProposalController@sent')->name('proposal.sent');
        Route::get('proposal/{id}/resent', 'ProposalController@resent')->name('proposal.resent');

        Route::resource('proposal', 'ProposalController');
        Route::get('proposal/create/{cid}', 'ProposalController@create')->name('proposal.create');
    }
);

Route::get(
    '/proposal/preview/{template}/{color}', 'ProposalController@previewProposal')->name('proposal.preview');
Route::post(
    '/proposal/template/setting', 'ProposalController@saveProposalTemplateSettings')->name('proposal.template.setting');

Route::resource('goal', 'GoalController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//Budget Planner //

Route::resource('budget', 'BudgetController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('custom-field', 'CustomFieldController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::post('chart-of-account/subtype', 'ChartOfAccountController@getSubType')->name('charofAccount.subType')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::resource('chart-of-account', 'ChartOfAccountController');
    }
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::post('journal-entry/account/destroy', 'JournalEntryController@accountDestroy')->name('journal.account.destroy');
        Route::resource('journal-entry', 'JournalEntryController');
    }
);

// Client Module
Route::resource('clients', 'ClientController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any('client-reset-password/{id}', 'ClientController@clientPassword')->name('clients.reset');
Route::post('client-reset-password/{id}', 'ClientController@clientPasswordReset')->name('client.password.update');
// Deal Module
Route::post(
    '/deals/user', 'DealController@jsonUser')->name('deal.user.json');
Route::post(
    '/deals/order', 'DealController@order')->name('deals.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/change-pipeline', 'DealController@changePipeline')->name('deals.change.pipeline')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/change-deal-status/{id}', 'DealController@changeStatus')->name('deals.change.status')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/labels', 'DealController@labels')->name('deals.labels')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/labels', 'DealController@labelStore')->name('deals.labels.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/users', 'DealController@userEdit')->name('deals.users.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/users', 'DealController@userUpdate')->name('deals.users.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/users/{uid}', 'DealController@userDestroy')->name('deals.users.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/clients', 'DealController@clientEdit')->name('deals.clients.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/clients', 'DealController@clientUpdate')->name('deals.clients.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/clients/{uid}', 'DealController@clientDestroy')->name('deals.clients.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/products', 'DealController@productEdit')->name('deals.products.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/products', 'DealController@productUpdate')->name('deals.products.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/products/{uid}', 'DealController@productDestroy')->name('deals.products.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/sources', 'DealController@sourceEdit')->name('deals.sources.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/sources', 'DealController@sourceUpdate')->name('deals.sources.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/sources/{uid}', 'DealController@sourceDestroy')->name('deals.sources.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/file', 'DealController@fileUpload')->name('deals.file.upload')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/file/{fid}', 'DealController@fileDownload')->name('deals.file.download')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/file/delete/{fid}', 'DealController@fileDelete')->name('deals.file.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/note', 'DealController@noteStore')->name('deals.note.store')->middleware(['auth']);
Route::get(
    '/deals/{id}/task', 'DealController@taskCreate')->name('deals.tasks.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/task', 'DealController@taskStore')->name('deals.tasks.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/task/{tid}/show', 'DealController@taskShow')->name('deals.tasks.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/task/{tid}/edit', 'DealController@taskEdit')->name('deals.tasks.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/task/{tid}', 'DealController@taskUpdate')->name('deals.tasks.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/task_status/{tid}', 'DealController@taskUpdateStatus')->name('deals.tasks.update_status')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/deals/{id}/task/{tid}', 'DealController@taskDestroy')->name('deals.tasks.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/discussions', 'DealController@discussionCreate')->name('deals.discussions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/discussions', 'DealController@discussionStore')->name('deals.discussion.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/{id}/permission/{cid}', 'DealController@permission')->name('deals.client.permission')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/permission/{cid}', 'DealController@permissionStore')->name('deals.client.permissions.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/deals/list', 'DealController@deal_list')->name('deals.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Deal Calls
Route::get(
    '/deals/{id}/call', 'DealController@callCreate')->name('deals.calls.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/call', 'DealController@callStore')->name('deals.calls.store')->middleware(['auth']);
Route::get(
    '/deals/{id}/call/{cid}/edit', 'DealController@callEdit')->name('deals.calls.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/deals/{id}/call/{cid}', 'DealController@callUpdate')->name('deals.calls.update')->middleware(['auth']);
Route::delete(
    '/deals/{id}/call/{cid}', 'DealController@callDestroy')->name('deals.calls.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Deal Email
Route::get(
    '/deals/{id}/email', 'DealController@emailCreate')->name('deals.emails.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/deals/{id}/email', 'DealController@emailStore')->name('deals.emails.store')->middleware(['auth']);
Route::resource('deals', 'DealController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// end Deal Module

Route::get(
    '/search', 'UserController@search')->name('search.json');
Route::post(
    '/stages/order', 'StageController@order')->name('stages.order');
Route::post(
    '/stages/json', 'StageController@json')->name('stages.json');

Route::resource('stages', 'StageController');
Route::resource('pipelines', 'PipelineController');
Route::resource('labels', 'LabelController');
Route::resource('sources', 'SourceController');
Route::resource('payments', 'PaymentController');
Route::resource('custom_fields', 'CustomFieldController');

// Leads Module
Route::post(
    '/lead_stages/order', 'LeadStageController@order')->name('lead_stages.order');
Route::resource('lead_stages', 'LeadStageController')->middleware(['auth']);
Route::post(
    '/leads/json', 'LeadController@json')->name('leads.json');
Route::post(
    '/leads/order', 'LeadController@order')->name('leads.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/list', 'LeadController@lead_list')->name('leads.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/file', 'LeadController@fileUpload')->name('leads.file.upload')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/file/{fid}', 'LeadController@fileDownload')->name('leads.file.download')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/file/delete/{fid}', 'LeadController@fileDelete')->name('leads.file.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/note', 'LeadController@noteStore')->name('leads.note.store')->middleware(['auth']);
Route::get(
    '/leads/{id}/labels', 'LeadController@labels')->name('leads.labels')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/labels', 'LeadController@labelStore')->name('leads.labels.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/users', 'LeadController@userEdit')->name('leads.users.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/users', 'LeadController@userUpdate')->name('leads.users.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/users/{uid}', 'LeadController@userDestroy')->name('leads.users.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/products', 'LeadController@productEdit')->name('leads.products.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/products', 'LeadController@productUpdate')->name('leads.products.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/products/{uid}', 'LeadController@productDestroy')->name('leads.products.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/sources', 'LeadController@sourceEdit')->name('leads.sources.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/sources', 'LeadController@sourceUpdate')->name('leads.sources.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/leads/{id}/sources/{uid}', 'LeadController@sourceDestroy')->name('leads.sources.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/discussions', 'LeadController@discussionCreate')->name('leads.discussions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/discussions', 'LeadController@discussionStore')->name('leads.discussion.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/leads/{id}/show_convert', 'LeadController@showConvertToDeal')->name('leads.convert.deal')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/convert', 'LeadController@convertToDeal')->name('leads.convert.to.deal')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Lead Calls
Route::get(
    '/leads/{id}/call', 'LeadController@callCreate')->name('leads.calls.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/call', 'LeadController@callStore')->name('leads.calls.store')->middleware(['auth']);
Route::get(
    '/leads/{id}/call/{cid}/edit', 'LeadController@callEdit')->name('leads.calls.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::put(
    '/leads/{id}/call/{cid}', 'LeadController@callUpdate')->name('leads.calls.update')->middleware(['auth']);
Route::delete(
    '/leads/{id}/call/{cid}', 'LeadController@callDestroy')->name('leads.calls.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Lead Email
Route::get(
    '/leads/{id}/email', 'LeadController@emailCreate')->name('leads.emails.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/leads/{id}/email', 'LeadController@emailStore')->name('leads.emails.store')->middleware(['auth']);
Route::resource('leads', 'LeadController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// end Leads Module

Route::get('user/{id}/plan', 'UserController@upgradePlan')->name('plan.upgrade')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('user/{id}/plan/{pid}', 'UserController@activePlan')->name('plan.active')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/{uid}/notification/seen', 'UserController@notificationSeen')->name('notification.seen');

// Email Templates
Route::get('email_template_lang/{id}/{lang?}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language')->middleware(['auth']);
Route::put('email_template_store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language')->middleware(['auth']);
Route::put('email_template_status/{id}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);
Route::resource('email_template', 'EmailTemplateController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Email Templates

// HRM

Route::resource('user', 'UserController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/json', 'EmployeeController@json')->name('employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('branch/employee/json', 'EmployeeController@employeeJson')->name('branch.employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee-profile', 'EmployeeController@profile')->name('employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('show-employee-profile/{id}', 'EmployeeController@profileShow')->name('show.employee.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('lastlogin', 'EmployeeController@lastLogin')->name('lastlogin')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('employee', 'EmployeeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/getdepartment', 'EmployeeController@getDepartment')->name('employee.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('department', 'DepartmentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('designation', 'DesignationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('document', 'DocumentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('branch', 'BranchController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Hrm EmployeeController

Route::get('employee/salary/{eid}', 'SetSalaryController@employeeBasicSalary')->name('employee.basic.salary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
//payslip

Route::resource('paysliptype', 'PayslipTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('allowance', 'AllowanceController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('commission', 'CommissionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('allowanceoption', 'AllowanceOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('loanoption', 'LoanOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('deductionoption', 'DeductionOptionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('loan', 'LoanController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('saturationdeduction', 'SaturationDeductionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('otherpayment', 'OtherPaymentController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('overtime', 'OvertimeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('employee/salary/{eid}', 'SetSalaryController@employeeBasicSalary')->name('employee.basic.salary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('employee/update/sallary/{id}', 'SetSalaryController@employeeUpdateSalary')->name('employee.salary.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('salary/employeeSalary', 'SetSalaryController@employeeSalary')->name('employeesalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('setsalary', 'SetSalaryController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('allowances/create/{eid}', 'AllowanceController@allowanceCreate')->name('allowances.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('commissions/create/{eid}', 'CommissionController@commissionCreate')->name('commissions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('loans/create/{eid}', 'LoanController@loanCreate')->name('loans.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('saturationdeductions/create/{eid}', 'SaturationDeductionController@saturationdeductionCreate')->name('saturationdeductions.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('otherpayments/create/{eid}', 'OtherPaymentController@otherpaymentCreate')->name('otherpayments.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('overtimes/create/{eid}', 'OvertimeController@overtimeCreate')->name('overtimes.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('payslip/paysalary/{id}/{date}', 'PaySlipController@paysalary')->name('payslip.paysalary')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/bulk_pay_create/{date}', 'PaySlipController@bulk_pay_create')->name('payslip.bulk_pay_create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/bulkpayment/{date}', 'PaySlipController@bulkpayment')->name('payslip.bulkpayment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/search_json', 'PaySlipController@search_json')->name('payslip.search_json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/employeepayslip', 'PaySlipController@employeepayslip')->name('payslip.employeepayslip')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/showemployee/{id}', 'PaySlipController@showemployee')->name('payslip.showemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/editemployee/{id}', 'PaySlipController@editemployee')->name('payslip.editemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('payslip/editemployee/{id}', 'PaySlipController@updateEmployee')->name('payslip.updateemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/pdf/{id}/{m}', 'PaySlipController@pdf')->name('payslip.pdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/payslipPdf/{id}', 'PaySlipController@payslipPdf')->name('payslip.payslipPdf')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/send/{id}/{m}', 'PaySlipController@send')->name('payslip.send')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('payslip/delete/{id}', 'PaySlipController@destroy')->name('payslip.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('payslip', 'PaySlipController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('company-policy', 'CompanyPolicyController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('indicator', 'IndicatorController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('appraisal', 'AppraisalController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('branch/employee/json', 'EmployeeController@employeeJson')->name('branch.employee.json')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltype', 'GoalTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('goaltracking', 'GoalTrackingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('account-assets', 'AssetController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('event/getdepartment', 'EventController@getdepartment')->name('event.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('event/getemployee', 'EventController@getemployee')->name('event.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('event', 'EventController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('meeting/getdepartment', 'MeetingController@getdepartment')->name('meeting.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('meeting/getemployee', 'MeetingController@getemployee')->name('meeting.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('meeting', 'MeetingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainingtype', 'TrainingTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('trainer', 'TrainerController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('training/status', 'TrainingController@updateStatus')->name('training.status')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('training', 'TrainingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// HRM - HR Module

Route::resource('awardtype', 'AwardTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('award', 'AwardController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('resignation', 'ResignationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('travel', 'TravelController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('promotion', 'PromotionController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('complaint', 'ComplaintController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('warning', 'WarningController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('termination', 'TerminationController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('termination/{id}/description', 'TerminationController@description')->name('termination.description');

Route::resource('terminationtype', 'TerminationTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getdepartment', 'AnnouncementController@getdepartment')->name('announcement.getdepartment')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('announcement/getemployee', 'AnnouncementController@getemployee')->name('announcement.getemployee')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('announcement', 'AnnouncementController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('holiday', 'HolidayController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('holiday-calender', 'HolidayController@calender')->name('holiday.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

//------------------------------------  Recurtment --------------------------------

Route::resource('job-category', 'JobCategoryController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('job-stage', 'JobStageController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-stage/order', 'JobStageController@order')->name('job.stage.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('job', 'JobController')->middleware(['auth', 'XSS']);
Route::get('career/{id}/{lang}', 'JobController@career')->name('career')->middleware(['XSS']);
Route::get('job/requirement/{code}/{lang}', 'JobController@jobRequirement')->name('job.requirement')->middleware(['XSS']);
Route::get('job/apply/{code}/{lang}', 'JobController@jobApply')->name('job.apply')->middleware(['XSS']);
Route::post('job/apply/data/{code}', 'JobController@jobApplyData')->name('job.apply.data')->middleware(['XSS']);

Route::get('candidates-job-applications', 'JobApplicationController@candidate')->name('job.application.candidate')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('job-application', 'JobApplicationController')->middleware(['auth', 'XSS']);

Route::post('job-application/order', 'JobApplicationController@order')->name('job.application.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/rating', 'JobApplicationController@rating')->name('job.application.rating')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/archive', 'JobApplicationController@archive')->name('job.application.archive')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/{id}/skill/store', 'JobApplicationController@addSkill')->name('job.application.skill.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/{id}/note/store', 'JobApplicationController@addNote')->name('job.application.note.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-application/{id}/note/destroy', 'JobApplicationController@destroyNote')->name('job.application.note.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-application/getByJob', 'JobApplicationController@getByJob')->name('get.job.application')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('job-onboard', 'JobApplicationController@jobOnBoard')->name('job.on.board')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/create/{id}', 'JobApplicationController@jobBoardCreate')->name('job.on.board.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/store/{id}', 'JobApplicationController@jobBoardStore')->name('job.on.board.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get('job-onboard/edit/{id}', 'JobApplicationController@jobBoardEdit')->name('job.on.board.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/update/{id}', 'JobApplicationController@jobBoardUpdate')->name('job.on.board.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('job-onboard/delete/{id}', 'JobApplicationController@jobBoardDelete')->name('job.on.board.delete')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('job-onboard/convert/{id}', 'JobApplicationController@jobBoardConvert')->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('job-onboard/convert/{id}', 'JobApplicationController@jobBoardConvertData')->name('job.on.board.convert')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('job-application/stage/change', 'JobApplicationController@stageChange')->name('job.application.stage.change')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('custom-question', 'CustomQuestionController')->middleware(['auth', 'XSS']);
Route::resource('interview-schedule', 'InterviewScheduleController')->middleware(['auth', 'XSS']);
Route::get('interview-schedule/create/{id?}', 'InterviewScheduleController@create')->name('interview-schedule.create')->middleware(['auth', 'XSS']);
Route::get(
    'taskboard/{view?}', 'ProjectTaskController@taskBoard')->name('taskBoard.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'taskboard-view', 'ProjectTaskController@taskboardView')->name('project.taskboard.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('document-upload', 'DucumentUploadController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('transfer', 'TransferController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('attendanceemployee/bulkattendance', 'AttendanceEmployeeController@bulkAttendance')->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('attendanceemployee/bulkattendance', 'AttendanceEmployeeController@bulkAttendanceData')->name('attendanceemployee.bulkattendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post('attendanceemployee/attendance', 'AttendanceEmployeeController@attendance')->name('attendanceemployee.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::resource('attendanceemployee', 'AttendanceEmployeeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leavetype', 'LeaveTypeController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/leave', 'ReportController@leave')->name('report.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee/{id}/leave/{status}/{type}/{month}/{year}', 'ReportController@employeeLeave')->name('report.employee.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('leave/{id}/action', 'LeaveController@action')->name('leave.action')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/changeaction', 'LeaveController@changeaction')->name('leave.changeaction')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('leave/jsoncount', 'LeaveController@jsoncount')->name('leave.jsoncount')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('leave', 'LeaveController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-leave', 'ReportController@leave')->name('report.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('employee/{id}/leave/{status}/{type}/{month}/{year}', 'ReportController@employeeLeave')->name('report.employee.leave')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-payroll', 'ReportController@payroll')->name('report.payroll')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('reports-monthly-attendance', 'ReportController@monthlyAttendance')->name('report.monthly.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('report/attendance/{month}/{branch}/{department}', 'ReportController@exportCsv')->name('report.attendance')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// User Module
Route::get(
    'users/{view?}', 'UserController@index')->name('users')->middleware(
    [
        'auth',
        'XSS',
        'permissions',

    ]
);
Route::get(
    'users-view', 'UserController@filterUserView')->name('filter.user.view')->middleware(
    [
        'auth',
        'XSS',
        'permissions',
    ]
);
Route::get(
    'checkuserexists', 'UserController@checkUserExists')->name('user.exists')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'profile', 'UserController@profile')->name('profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/profile', 'UserController@updateProfile')->name('update.profile')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'user/info/{id}', 'UserController@userInfo')->name('users.info')->middleware(
    [
        'auth',
        'XSS',
        'permissions',
    ]
);
Route::get(
    'user/{id}/info/{type}', 'UserController@getProjectTask')->name('user.info.popup')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    'users/{id}', 'UserController@destroy')->name('user.destroy')->middleware(
    [
        'auth',
        'XSS',
        'permissions',
    ]
);
// End User Module

// Search
Route::get(
    '/search', 'UserController@search')->name('search.json');

// end

// Milestone Module
Route::get(
    'projects/{id}/milestone', 'ProjectController@milestone')->name('project.milestone')->middleware(
    [
        'auth',
        'XSS',
    ]
);
//Route::delete(
//    '/projects/{id}/users/{uid}', [
//                                    'as' => 'projects.users.destroy',
//                                    'uses' => 'ProjectController@userDestroy',
//                                ]
//)->middleware(
//    [
//        'auth',
//        'XSS',
//    ]
//);
Route::post(
    'projects/{id}/milestone', 'ProjectController@milestoneStore')->name('project.milestone.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects/milestone/{id}/edit', 'ProjectController@milestoneEdit')->name('project.milestone.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/milestone/{id}', 'ProjectController@milestoneUpdate')->name('project.milestone.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    'projects/milestone/{id}', 'ProjectController@milestoneDestroy')->name('project.milestone.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects/milestone/{id}/show', 'ProjectController@milestoneShow')->name('project.milestone.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Milestone

// Project Module
Route::get(
    'invite-project-member/{id}', 'ProjectController@inviteMemberView')->name('invite.project.member.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'invite-project-user-member', 'ProjectController@inviteProjectUserMember')->name('invite.project.user.member')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::delete(
    'projects/{id}/users/{uid}', 'ProjectController@destroyProjectUser')->name('projects.user.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    'project/{view?}', 'ProjectController@index')->name('projects.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects-view', 'ProjectController@filterProjectView')->name('filter.project.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('projects/{id}/store-stages/{slug}', 'ProjectController@storeProjectTaskStages')->name('project.stages.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    'remove-user-from-project/{project_id}/{user_id}', 'ProjectController@removeUserFromProject')->name('remove.user.from.project')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects-users', 'ProjectController@loadUser')->name('project.user')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'projects/{id}/gantt/{duration?}', 'ProjectController@gantt')->name('projects.gantt')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/{id}/gantt', 'ProjectController@ganttPost')->name('projects.gantt.post')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('projects', 'ProjectController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// User Permission
Route::get(
    'projects/{id}/user/{uid}/permission', 'ProjectController@userPermission')->name('projects.user.permission')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    'projects/{id}/user/{uid}/permission', 'ProjectController@userPermissionStore')->name('projects.user.permission.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Project Module
// Task Module
Route::get(
    'stage/{id}/tasks', 'ProjectTaskController@getStageTasks')->name('stage.tasks')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Project Task Module
Route::get(
    '/projects/{id}/task', 'ProjectTaskController@index')->name('projects.tasks.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{pid}/task/{sid}', 'ProjectTaskController@create')->name('projects.tasks.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{pid}/task/{sid}', 'ProjectTaskController@store')->name('projects.tasks.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/task/{tid}/show', 'ProjectTaskController@show')->name('projects.tasks.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/task/{tid}/edit', 'ProjectTaskController@edit')->name('projects.tasks.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{id}/task/update/{tid}', 'ProjectTaskController@update')->name('projects.tasks.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/projects/{id}/task/{tid}', 'ProjectTaskController@destroy')->name('projects.tasks.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    '/projects/{id}/task/order', 'ProjectTaskController@taskOrderUpdate')->name('tasks.update.order')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::patch(
    'update-task-priority-color', 'ProjectTaskController@updateTaskPriorityColor')->name('update.task.priority.color')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::post(
    '/projects/{id}/comment/{tid}/file', 'ProjectTaskController@commentStoreFile')->name('comment.store.file');
Route::delete(
    '/projects/{id}/comment/{tid}/file/{fid}', 'ProjectTaskController@commentDestroyFile')->name('comment.destroy.file');
Route::post(
    '/projects/{id}/comment/{tid}', 'ProjectTaskController@commentStore')->name('comment.store');
Route::delete(
    '/projects/{id}/comment/{tid}/{cid}', 'ProjectTaskController@commentDestroy')->name('comment.destroy');
Route::post(
    '/projects/{id}/checklist/{tid}', 'ProjectTaskController@checklistStore')->name('checklist.store');
Route::post(
    '/projects/{id}/checklist/update/{cid}', 'ProjectTaskController@checklistUpdate')->name('checklist.update');
Route::delete(
    '/projects/{id}/checklist/{cid}', 'ProjectTaskController@checklistDestroy')->name('checklist.destroy');
Route::post(
    '/projects/{id}/change/{tid}/fav', 'ProjectTaskController@changeFav')->name('change.fav');
Route::post(
    '/projects/{id}/change/{tid}/complete', 'ProjectTaskController@changeCom')->name('change.complete');
Route::post(
    '/projects/{id}/change/{tid}/progress', 'ProjectTaskController@changeProg')->name('change.progress');
Route::get(
    '/projects/task/{id}/get', 'ProjectTaskController@taskGet')->name('projects.tasks.get')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/calendar/{id}/show', 'ProjectTaskController@calendarShow')->name('task.calendar.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/calendar/{id}/drag', 'ProjectTaskController@calendarDrag')->name('task.calendar.drag');
Route::get(
    'calendar/{task}/{pid?}', 'ProjectTaskController@calendarView')->name('task.calendar')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::resource('project-task-stages', 'TaskStageController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/project-task-stages/order', 'TaskStageController@order')->name('project-task-stages.order');
Route::post('project-task-new-stage', 'TaskStageController@storingValue')->name('new-task-stage')->middleware(
    [
        'auth',
        'XSS',
    ]
);
// End Task Module

// Project Expense Module
Route::get(
    '/projects/{id}/expense', 'ExpenseController@index')->name('projects.expenses.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{pid}/expense/create', 'ExpenseController@create')->name('projects.expenses.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{pid}/expense/store', 'ExpenseController@store')->name('projects.expenses.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/projects/{id}/expense/{eid}/edit', 'ExpenseController@edit')->name('projects.expenses.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/projects/{id}/expense/{eid}', 'ExpenseController@update')->name('projects.expenses.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/projects/{eid}/expense/', 'ExpenseController@destroy')->name('projects.expenses.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/expense-list', 'ExpenseController@expenseList')->name('expense.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::resource('contractType', 'ContractTypeController');
    }
);

// Project Timesheet
Route::get('append-timesheet-task-html', 'TimesheetController@appendTimesheetTaskHTML')->name('append.timesheet.task.html')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-table-view', 'TimesheetController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-view', 'TimesheetController@filterTimesheetView')->name('filter.timesheet.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-list', 'TimesheetController@timesheetList')->name('timesheet.list')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('timesheet-list-get', 'TimesheetController@timesheetListGet')->name('timesheet.list.get')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::get(
    '/project/{id}/timesheet', 'TimesheetController@timesheetView')->name('timesheet.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/{id}/timesheet/create', 'TimesheetController@timesheetCreate')->name('timesheet.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/project/timesheet', 'TimesheetController@timesheetStore')->name('timesheet.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/project/timesheet/{project_id}/edit/{timesheet_id}', 'TimesheetController@timesheetEdit')->name('timesheet.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any(
    '/project/timesheet/update/{timesheet_id}', 'TimesheetController@timesheetUpdate')->name('timesheet.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/project/timesheet/{timesheet_id}', 'TimesheetController@timesheetDestroy')->name('timesheet.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::middleware('auth', 'XSS')->group(function () {
        Route::resource('projectstages', 'ProjectstagesController');
        Route::post(
            '/projectstages/order', 'ProjectstagesController@order')->name('projectstages.order');
        Route::post('projects/bug/kanban/order', 'ProjectController@bugKanbanOrder')->name('bug.kanban.order');
        Route::get('projects/{id}/bug/kanban', 'ProjectController@bugKanban')->name('task.bug.kanban');
        Route::get('projects/{id}/bug', 'ProjectController@bug')->name('task.bug');
        Route::get('projects/{id}/bug/create', 'ProjectController@bugCreate')->name('task.bug.create');
        Route::post('projects/{id}/bug/store', 'ProjectController@bugStore')->name('task.bug.store');
        Route::get('projects/{id}/bug/{bid}/edit', 'ProjectController@bugEdit')->name('task.bug.edit');
        Route::post('projects/{id}/bug/{bid}/update', 'ProjectController@bugUpdate')->name('task.bug.update');
        Route::delete('projects/{id}/bug/{bid}/destroy', 'ProjectController@bugDestroy')->name('task.bug.destroy');
        Route::get('projects/{id}/bug/{bid}/show', 'ProjectController@bugShow')->name('task.bug.show');
        Route::post('projects/{id}/bug/{bid}/comment', 'ProjectController@bugCommentStore')->name('bug.comment.store');
        Route::post('projects/bug/{bid}/file', 'ProjectController@bugCommentStoreFile')->name('bug.comment.file.store');
        Route::delete('projects/bug/comment/{id}', 'ProjectController@bugCommentDestroy')->name('bug.comment.destroy');
        Route::delete('projects/bug/file/{id}', 'ProjectController@bugCommentDestroyFile')->name('bug.comment.file.destroy');
        Route::resource('bugstatus', 'BugStatusController');
        Route::post(
            '/bugstatus/order', 'BugStatusController@order')->name('bugstatus.order');

        Route::get(
            'bugs-report/{view?}', 'ProjectTaskController@allBugList')->name('bugs.view')->middleware(
            [
                'auth',
                'XSS',
            ]
        );
    }
);
// User_Todo Module
Route::post(
    '/todo/create', 'UserController@todo_store')->name('todo.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post(
    '/todo/{id}/update', 'UserController@todo_update')->name('todo.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete(
    '/todo/{id}', 'UserController@todo_destroy')->name('todo.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/change/mode', 'UserController@changeMode')->name('change.mode');

Route::get(
    'dashboard-view', 'DashboardController@filterView')->name('dashboard.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    'dashboard', 'DashboardController@clientView')->name('client.dashboard.view')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// saas
Route::resource('users', 'UserController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
        'permissions',
    ]
);
Route::resource('plans', 'PlanController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::resource('coupons', 'CouponController')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
// Orders

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('/orders', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    }
);
Route::get(
    '/apply-coupon', 'CouponController@applyCoupon')->name('apply.coupon')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Form Builder ====================================//

// Form Builder
Route::resource('form_builder', 'FormBuilderController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form link base view
Route::get('/form/{code}', 'FormBuilderController@formView')->name('form.view')->middleware(['XSS']);
Route::post('/form_view_store', 'FormBuilderController@formViewStore')->name('form.view.store')->middleware(['XSS']);

// Form Field
Route::get('/form_builder/{id}/field', 'FormBuilderController@fieldCreate')->name('form.field.create')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_builder/{id}/field', 'FormBuilderController@fieldStore')->name('form.field.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/form_builder/{id}/field/{fid}/show', 'FormBuilderController@fieldShow')->name('form.field.show')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/form_builder/{id}/field/{fid}/edit', 'FormBuilderController@fieldEdit')->name('form.field.edit')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_builder/{id}/field/{fid}', 'FormBuilderController@fieldUpdate')->name('form.field.update')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::delete('/form_builder/{id}/field/{fid}', 'FormBuilderController@fieldDestroy')->name('form.field.destroy')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form Response
Route::get('/form_response/{id}', 'FormBuilderController@viewResponse')->name('form.response')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/response/{id}', 'FormBuilderController@responseDetail')->name('response.detail')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// Form Field Bind
Route::get('/form_field/{id}', 'FormBuilderController@formFieldBind')->name('form.field.bind')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/form_field_store/{id}', 'FormBuilderController@bindStore')->name('form.bind.store')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// end Form Builder

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('contract/{id}/description', 'ContractController@description')->name('contract.description');
        Route::get('contract/grid', 'ContractController@grid')->name('contract.grid');
        Route::resource('contract', 'ContractController');
    }
);

//================================= Custom Landing Page ====================================//

Route::get('/landingpage', 'LandingPageSectionController@index')->name('custom_landing_page.index')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/LandingPage/show/{id}', 'LandingPageSectionController@show');
Route::post('/LandingPage/setConetent', 'LandingPageSectionController@setConetent')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get(
    '/get_landing_page_section/{name}', function ($name) {
        $plans = \DB::table('plans')->get();

        return view('custom_landing_page.'.$name, compact('plans'));
    }
);
Route::post('/LandingPage/removeSection/{id}', 'LandingPageSectionController@removeSection')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/setOrder', 'LandingPageSectionController@setOrder')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::post('/LandingPage/copySection', 'LandingPageSectionController@copySection')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::get('/customer/invoice/{id}/', 'InvoiceController@invoiceLink')->name('invoice.link.copy');

Route::get('/customer/bill/{id}/', 'BillController@invoiceLink')->name('bill.link.copy');

Route::get('/customer/proposal/{id}/', 'ProposalController@invoiceLink')->name('proposal.link.copy');

Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);
Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Plan Payment Gateways  ====================================//

Route::post('/plan-pay-with-paystack', 'PaystackPaymentController@planPayWithPaystack')->name('plan.pay.with.paystack')->middleware(['auth', 'XSS']);
Route::get('/plan/paystack/{pay_id}/{plan_id}', 'PaystackPaymentController@getPaymentStatus')->name('plan.paystack');

Route::post('/plan-pay-with-flaterwave', 'FlutterwavePaymentController@planPayWithFlutterwave')->name('plan.pay.with.flaterwave')->middleware(['auth', 'XSS']);
Route::get('/plan/flaterwave/{txref}/{plan_id}', 'FlutterwavePaymentController@getPaymentStatus')->name('plan.flaterwave');

Route::post('/plan-pay-with-razorpay', 'RazorpayPaymentController@planPayWithRazorpay')->name('plan.pay.with.razorpay')->middleware(['auth', 'XSS']);
Route::get('/plan/razorpay/{txref}/{plan_id}', 'RazorpayPaymentController@getPaymentStatus')->name('plan.razorpay');

Route::post('/plan-pay-with-paytm', 'PaytmPaymentController@planPayWithPaytm')->name('plan.pay.with.paytm')->middleware(['auth', 'XSS']);
Route::post('/plan/paytm/{plan}', 'PaytmPaymentController@getPaymentStatus')->name('plan.paytm');

Route::post('/plan-pay-with-mercado', 'MercadoPaymentController@planPayWithMercado')->name('plan.pay.with.mercado')->middleware(['auth', 'XSS']);
Route::get('/plan/mercado/{plan}/{amount}', 'MercadoPaymentController@getPaymentStatus')->name('plan.mercado');

Route::post('/plan-pay-with-mollie', 'MolliePaymentController@planPayWithMollie')->name('plan.pay.with.mollie')->middleware(['auth', 'XSS']);
Route::get('/plan/mollie/{plan}', 'MolliePaymentController@getPaymentStatus')->name('plan.mollie');

Route::post('/plan-pay-with-skrill', 'SkrillPaymentController@planPayWithSkrill')->name('plan.pay.with.skrill')->middleware(['auth', 'XSS']);
Route::get('/plan/skrill/{plan}', 'SkrillPaymentController@getPaymentStatus')->name('plan.skrill');

Route::post('/plan-pay-with-coingate', 'CoingatePaymentController@planPayWithCoingate')->name('plan.pay.with.coingate')->middleware(['auth', 'XSS']);
Route::get('/plan/coingate/{plan}', 'CoingatePaymentController@getPaymentStatus')->name('plan.coingate');

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('order', 'StripePaymentController@index')->name('order.index');
        Route::get('/stripe/{code}', 'StripePaymentController@stripe')->name('stripe');
        Route::post('/stripe', 'StripePaymentController@stripePost')->name('stripe.post');
    }
);

Route::post('plan-pay-with-paypal', 'PaypalController@planPayWithPaypal')->name('plan.pay.with.paypal')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

Route::get('{id}/plan-get-payment-status', 'PaypalController@planGetPaymentStatus')->name('plan.get.payment.status')->middleware(
    [
        'auth',
        'XSS',
        'revalidate',
    ]
);

//================================= Invoice Payment Gateways  ====================================//

Route::post('customer/{id}/payment', 'StripePaymentController@addpayment')->name('customer.payment');

Route::post('{id}/pay-with-paypal', 'PaypalController@customerPayWithPaypal')->name('customer.pay.with.paypal');
Route::get('{id}/get-payment-status', 'PaypalController@customerGetPaymentStatus')->name('customer.get.payment.status')->middleware(
    [
        'XSS',

    ]
);

Route::post('/customer-pay-with-paystack', 'PaystackPaymentController@customerPayWithPaystack')->name('customer.pay.with.paystack')->middleware(['XSS']);
Route::get('/customer/paystack/{pay_id}/{invoice_id}', 'PaystackPaymentController@getInvoicePaymentStatus')->name('customer.paystack');

Route::post('/customer-pay-with-flaterwave', 'FlutterwavePaymentController@customerPayWithFlutterwave')->name('customer.pay.with.flaterwave')->middleware(['XSS']);
Route::get('/customer/flaterwave/{txref}/{invoice_id}', 'FlutterwavePaymentController@getInvoicePaymentStatus')->name('customer.flaterwave');

Route::post('/customer-pay-with-razorpay', 'RazorpayPaymentController@customerPayWithRazorpay')->name('customer.pay.with.razorpay')->middleware(['XSS']);
Route::get('/customer/razorpay/{txref}/{invoice_id}', 'RazorpayPaymentController@getInvoicePaymentStatus')->name('customer.razorpay');

Route::post('/customer-pay-with-paytm', 'PaytmPaymentController@customerPayWithPaytm')->name('customer.pay.with.paytm')->middleware(['XSS']);
Route::post('/customer/paytm/{invoice}/{amount}', 'PaytmPaymentController@getInvoicePaymentStatus')->name('customer.paytm');

Route::post('/customer-pay-with-mercado', 'MercadoPaymentController@customerPayWithMercado')->name('customer.pay.with.mercado')->middleware(['XSS']);
Route::get('/customer/mercado/{invoice}', 'MercadoPaymentController@getInvoicePaymentStatus')->name('customer.mercado');

Route::post('/customer-pay-with-mollie', 'MolliePaymentController@customerPayWithMollie')->name('customer.pay.with.mollie')->middleware(['XSS']);
Route::get('/customer/mollie/{invoice}/{amount}', 'MolliePaymentController@getInvoicePaymentStatus')->name('customer.mollie');

Route::post('/customer-pay-with-skrill', 'SkrillPaymentController@customerPayWithSkrill')->name('customer.pay.with.skrill')->middleware(['XSS']);
Route::get('/customer/skrill/{invoice}/{amount}', 'SkrillPaymentController@getInvoicePaymentStatus')->name('customer.skrill');

Route::post('/customer-pay-with-coingate', 'CoingatePaymentController@customerPayWithCoingate')->name('customer.pay.with.coingate')->middleware(['XSS']);
Route::get('/customer/coingate/{invoice}/{amount}', 'CoingatePaymentController@getInvoicePaymentStatus')->name('customer.coingate');

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::get('support/{id}/reply', 'SupportController@reply')->name('support.reply');
        Route::post('support/{id}/reply', 'SupportController@replyAnswer')->name('support.reply.answer');
        Route::get('support/grid', 'SupportController@grid')->name('support.grid');
        Route::resource('support', 'SupportController');
    }
);

Route::resource('competencies', 'CompetenciesController')->middleware(
    [
        'auth',
        'XSS',
    ]
);

Route::middleware('auth', 'XSS', 'revalidate')->group(function () {
        Route::resource('performanceType', 'PerformanceTypeController');
    }
);

// Plan Request Module
Route::get('plan_request', 'PlanRequestController@index')->name('plan_request.index')->middleware(['auth', 'XSS']);
Route::get('request_frequency/{id}', 'PlanRequestController@requestView')->name('request.view')->middleware(['auth', 'XSS']);
Route::get('request_send/{id}', 'PlanRequestController@userRequest')->name('send.request')->middleware(['auth', 'XSS']);
Route::get('request_response/{id}/{response}', 'PlanRequestController@acceptRequest')->name('response.request')->middleware(['auth', 'XSS']);
Route::get('request_cancel/{id}', 'PlanRequestController@cancelRequest')->name('request.cancel')->middleware(['auth', 'XSS']);

//QR Code Module

//--------------------------------------------------------Import/Export Data Route-----------------------------------------------------------------

Route::get('export/productservice', 'ProductServiceController@export')->name('productservice.export');
Route::get('import/productservice/file', 'ProductServiceController@importFile')->name('productservice.file.import');
Route::post('import/productservice', 'ProductServiceController@import')->name('productservice.import');

Route::get('export/customer', 'CustomerController@export')->name('customer.export');
Route::get('import/customer/file', 'CustomerController@importFile')->name('customer.file.import');
Route::post('import/customer', 'CustomerController@import')->name('customer.import');

Route::get('export/vender', 'VenderController@export')->name('vender.export');
Route::get('import/vender/file', 'VenderController@importFile')->name('vender.file.import');
Route::post('import/vender', 'VenderController@import')->name('vender.import');

Route::get('export/invoice', 'InvoiceController@export')->name('invoice.export');

Route::get('export/proposal', 'ProposalController@export')->name('proposal.export');

Route::get('export/bill', 'BillController@export')->name('bill.export');

//=================================== Time-Tracker======================================================================
Route::post('stop-tracker', 'DashboardController@stopTracker')->name('stop.tracker')->middleware(['auth', 'XSS']);
Route::get('time-tracker', 'TimeTrackerController@index')->name('time.tracker')->middleware(['auth', 'XSS']);
Route::delete('tracker/{tid}/destroy', 'TimeTrackerController@Destroy')->name('tracker.destroy');
Route::post('tracker/image-view', 'TimeTrackerController@getTrackerImages')->name('tracker.image.view');
Route::delete('tracker/image-remove', 'TimeTrackerController@removeTrackerImages')->name('tracker.image.remove');
Route::get('projects/time-tracker/{id}', 'ProjectController@tracker')->name('projecttime.tracker')->middleware(['auth', 'XSS']);

//=================================== Zoom Meeting ======================================================================
Route::resource('zoom-meeting', 'ZoomMeetingController')->middleware(
    [
        'auth',
        'XSS',
    ]
);
Route::any('/zoom-meeting/projects/select/{bid}', 'ZoomMeetingController@projectwiseuser')->name('zoom-meeting.projects.select');
Route::get('zoom-meeting-calender', 'ZoomMeetingController@calender')->name('zoom-meeting.calender')->middleware(
    [
        'auth',
        'XSS',
    ]
);

// ------------------------------------- PaymentWall ------------------------------

Route::post('/paymentwalls', 'PaymentWallPaymentController@paymentwall')->name('plan.paymentwallpayment')->middleware(['XSS']);
Route::post('/plan-pay-with-paymentwall/{plan}', 'PaymentWallPaymentController@planPayWithPaymentWall')->name('plan.pay.with.paymentwall')->middleware(['XSS']);
Route::get('/plan/{flag}', 'PaymentWallPaymentController@planeerror')->name('error.plan.show');

Route::post('/paymentwall', 'PaymentWallPaymentController@invoicepaymentwall')->name('invoice.paymentwallpayment')->middleware(['XSS']);
Route::post('/invoice-pay-with-paymentwall/{plan}', 'PaymentWallPaymentController@invoicePayWithPaymentwall')->name('invoice.pay.with.paymentwall')->middleware(['XSS']);
Route::get('/invoices/{flag}/{invoice}', 'PaymentWallPaymentController@invoiceerror')->name('error.invoice.show');

Route::get('/charges/request', [App\Http\Livewire\Components\Charges\Request\Index::class, '__invoke'])->name('charges.request.index');
Route::get('/charges', [App\Http\Livewire\Components\Charges\View\Index::class, '__invoke'])->name('charges.index');
Route::post('/invoice/invoicetocharge/{id}/', 'InvoiceController@invoiceToCharge')->name('invoice.invoicetocharge');

Route::get('/payments-request', [App\Http\Livewire\Components\Payments\Request::class, '__invoke'])->name('payments.request.index')->middleware('auth');

Route::view('/help', 'admin.help')->name('help');

Route::get('/migrate', function () {
    Artisan::call('migrate');
    $output = Artisan::output();

    return $output ?: 'No hay migraciones para ejecutar.';
});
