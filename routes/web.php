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

use App\Models\Country;
use Illuminate\Support\Facades\Request;

Route::get('/', function (){
    return redirect()->route('users.showLoginForm');
})->name('home');



// CheckList Routes
Route::get('checklists', 'CheckListController@index')->name('checklists.index');
Route::get('checklists/{checklist_id}/versions', 'CheckListController@getVersions')->name('checklists.versions');
Route::get('checklists/{checklist_id}', 'CheckListController@show')
    ->name('checklists.show');
Route::get('checklists/{checklist_id}/versions/{version_id}', 'CheckListController@show')->name('checklists.show-version');
Route::get('checklists/{checklist_id}/versions/{version_id}/print', 'PrintController@index')->name('printable.print');


Route::post('checklists/{checklist_id}/update-order','CheckListController@updateOrder')->name('checklists.updateOrder');
Route::post('checklists', 'CheckListController@createCheckListWithVersionID')->name('checklists.create');
Route::post('checklists/{checklist_id}','CheckListController@updateChecklist')->name('checklists.update');
Route::post('checklists/{checklist_id}/subtitles', 'CheckListController@addOrUpdateSubtitle')->name('subtitle.createOrUpdate');

Route::delete('checklists/{checklist_id}', 'CheckListController@destroy')->name('checklists.destroy');
Route::delete('checklists/{checklist_id}/subtitles/{subtitle_id}', 'CheckListController@deleteSubtitle')->name('subtitle.destroy');


//Document Group
Route::get('checklists/{checklist_id}/versions/{version_id}/groups', 'GroupController@getGroups')->name('documentgroup.get');

Route::post('checklists/{checklist_id}/versions/{version_id}/groups','GroupController@updateOrCreateGroup')->name('documentgroup.createupdate');
Route::post('checklists/{checklist_id}/versions/{version_id}/groups/{group_id}/update-order','GroupController@updateOrder')->name('documentgroup.updateOrder');

Route::delete('checklists/{checklist_id}/versions/{version_id}/groups/{group_id}','GroupController@deleteGroup')->name('documentgroup.destroy');

//Autloads
Route::get('checklists/{checklist_id}/autoloads/{type?}','AutoloadController@getAutoloads')->name('autoloads.get');

//Document

Route::get('checklists/{checklist_id}/versions/{version_id}/compile-documents', 'DocumentController@compileDocumentsIndex')
    ->name('compile-documents.index');

Route::delete('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/base-documents/{base_document_id}', 'BaseAssetController@destroy')
    ->name('base-documents.delete');

Route::delete('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/inserts/{insert_document_id}', 'InsertAssetController@destroy')
    ->name('inserts.delete');

Route::post('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/update-order','DocumentController@updateOrder')->name('documents.updateOrder');
Route::post('checklists/{checklist_id}/versions/{version_id}/documents', 'DocumentController@store')->name('documents.create-update');
Route::post('checklists/{checklist_id}/versions/{version_id}/documents/compile',['uses'=> 'DocumentController@compileDocuments'])->name('documents.compile');

Route::get('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/inserts', 'DocumentController@documentInserts')
    ->name('documents.inserts');

Route::delete('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}', 'DocumentController@destroy')->name('documents.destroy');

Route::post('checklists/{checklist_id}/versions/{version_id}/upload-assets', 'DocumentController@uploadMultipleAssets')->name('documents.upload-assets');

Route::post('checklists/{checklist_id}/versions/{version_id}/set-bulk-attachments','DocumentController@setBulkAttachments')->name('documents.set-bulk-assets');
Route::post('checklists/{checklist_id}/versions/{version_id}/identify-assets','DocumentController@identifyAssets')->name('documents.identify-assets');


//Attachment
Route::post('attachment/upload', 'AttachmentController@upload')->name('attachment.store');

//Version
Route::post('checklists/{checklist_id}/versions/{version_id}','VersionController@updateVersionName')->name('version.update-name');
Route::post('checklists/{checklist_id}/versions','VersionController@createVersionWithVersionId')->name('version.create');

Route::delete('checklists/{checklist_id}/versions/{version_id}', 'VersionController@deleteVersionsWithVersionId')->name('version.destroy');

//SigPage
Route::post('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/sigpages/init', 'SigPageController@init')->name('sigpages.init');
Route::get('checklists/{checklist_id}/versions/{versions_id}/sigpages', 'SigPageController@index')->name('sigpages.index');

Route::post('checklists/{checklist_id}/versions/{versions_id}/documents/{document_id}/sigpages', 'SigPageController@storeOrUpdate')->name('sigpages.storeOrUpdate');
Route::post('checklists/{checklist_id}/versions/{versions_id}/sigpages/generate', 'SigPageController@generateSigPages')->name('sigpages.generate');

Route::get('checklists/{checklist_id}/versions/{version_id}/documents/{document_id}/sigpages/create-update/{sigpage_id?}', 'SigPageController@createOrUpdate')
    ->name('sigpages.createOrUpdate');

Route::delete('checklists/{checklist_id}/versions/{versions_id}/sigpages/{sigpage_id}', 'SigPageController@destroy')->name('sigpages.destroy');


//SigBlock
Route::get('checklists/{checklist_id}/version/{version_id}/sigblocks/{sigblock_id?}', 'SigBlockController@createOrEdit')->name('sigblock.createOrEdit');

Route::post('checklists/{checklist_id}/version/{version_id}/sigblocks', 'SigBlockController@storeOrUpdate')->name('sigblock.storeOrUpdate');

Route::delete('checklists/{checklist_id}/version/{version_id}/sigblocks/{sigblock_id?}', 'SigBlockController@destroy')->name('sigblock.destroy');

// Users

Route::get('/users/login', 'UserController@showLoginForm')
    ->name('users.showLoginForm');

Route::post('/users/login', 'UserController@login')
    ->name('users.login');

Route::get('/users/register', 'UserController@showRegisterForm')
    ->name('users.showRegisterForm');

Route::post('/users/register', 'UserController@register')
    ->name('users.register');

Route::get('/password/reset', 'UserController@showForgotPassword')
    ->name('users.forgot-password');

Route::post('/password/email', 'UserController@sendResetEmail')
    ->name('users.send-reset-email');

Route::get('/password/reset/{token}', 'UserController@showResetForm')
    ->name('users.reset-password');

Route::post('/password/reset/{token}/save', 'UserController@saveResetPassword')
    ->name('users.reset-password-save');

Route::post('users/logout', 'UserController@logout')
    ->name('users.logout');

Route::get('users/{user_id}/profile', 'UserController@profile')
    ->name('users.profile');

Route::post('users/{user_id}/profile', 'UserController@saveProfile')
    ->name('users.save-profile');

Route::get('/user/confirm/{confirmation_hash}', 'UserController@confirmUser')
    ->name('users.confirm-email');

Route::get('/user/account-unconfirmed', 'UserController@showInactiveAccount')
    ->name('users.account-unconfirmed');

Route::post('/user/resend-confirmation-email', 'UserController@resendConfirmationEmail')
    ->name('users.send-confirmation-mail');