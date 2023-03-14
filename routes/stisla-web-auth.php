<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BackupDatabaseController;
use App\Http\Controllers\CrudExampleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GroupMenuController;
use App\Http\Controllers\MenuManagementController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\UbuntuController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\YoutubeController;
use App\Http\Middleware\FileManagerPermission;
use Illuminate\Support\Facades\Route;

# DASHBOARD
Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

# SETTINGS
Route::get('settings/all', [SettingController::class, 'allSetting'])->name('settings.all');
Route::get('settings/{type}', [SettingController::class, 'index'])->name('settings.index');
Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

# PROFILE
Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
Route::put('profile', [ProfileController::class, 'update']);
Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
Route::put('profile/email', [ProfileController::class, 'updateEmail'])->name('profile.update-email');

# EXAMPLE STISLA
Route::view('datatable', 'stisla.examples.datatable.index')->name('datatable.index');
Route::view('form', 'stisla.examples.form.index')->name('form.index');
Route::view('chart-js', 'stisla.examples.chart-js.index')->name('chart-js.index');
Route::view('pricing', 'stisla.examples.pricing.index')->name('pricing.index');
Route::view('invoice', 'stisla.examples.invoice.index')->name('invoice.index');

# USER MANAGEMENT
Route::prefix('user-management')->as('user-management.')->group(function () {
    Route::get('users/force-login/{user}', [UserManagementController::class, 'forceLogin'])->name('users.force-login');
    // Route::get('yajra-users', [CrudExampleController::class, 'index'])->name('users.index-yajra');
    // Route::get('yajra-users/ajax', [CrudExampleController::class, 'yajraAjax'])->name('users.ajax-yajra');
    // Route::get('ajax-users', [CrudExampleController::class, 'index'])->name('users.index-ajax');
    // Route::get('yajra-ajax-users', [CrudExampleController::class, 'index'])->name('users.index-ajax-yajra');
    Route::get('users/pdf', [UserManagementController::class, 'pdf'])->name('users.pdf');
    Route::get('users/csv', [UserManagementController::class, 'csv'])->name('users.csv');
    Route::get('users/excel', [UserManagementController::class, 'excel'])->name('users.excel');
    Route::get('users/json', [UserManagementController::class, 'json'])->name('users.json');
    Route::get('users/import-excel-example', [UserManagementController::class, 'importExcelExample'])->name('users.import-excel-example');
    Route::post('users/import-excel', [UserManagementController::class, 'importExcel'])->name('users.import-excel');
    Route::resource('users', UserManagementController::class);

    # ROLES
    Route::get('roles/import-excel-example', [RoleController::class, 'importExcelExample'])->name('roles.import-excel-example');
    Route::post('roles/import-excel', [RoleController::class, 'importExcel'])->name('roles.import-excel');
    Route::resource('roles', RoleController::class);

    # PERMISSIONS
    Route::get('permissions/import-excel-example', [PermissionController::class, 'importExcelExample'])->name('permissions.import-excel-example');
    Route::post('permissions/import-excel', [PermissionController::class, 'importExcel'])->name('permissions.import-excel');
    Route::resource('permissions', PermissionController::class);

    # GROUP PERMISSIONS
    Route::get('permission-groups/import-excel-example', [PermissionGroupController::class, 'importExcelExample'])->name('permission-groups.import-excel-example');
    Route::post('permission-groups/import-excel', [PermissionGroupController::class, 'importExcel'])->name('permission-groups.import-excel');
    Route::resource('permission-groups', PermissionGroupController::class);
});

# ACTIVITY LOGS
Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
Route::get('activity-logs/print', [ActivityLogController::class, 'exportPrint'])->name('activity-logs.print');
Route::get('activity-logs/pdf', [ActivityLogController::class, 'pdf'])->name('activity-logs.pdf');
Route::get('activity-logs/csv', [ActivityLogController::class, 'csv'])->name('activity-logs.csv');
Route::get('activity-logs/json', [ActivityLogController::class, 'json'])->name('activity-logs.json');
Route::get('activity-logs/excel', [ActivityLogController::class, 'excel'])->name('activity-logs.excel');

# NOTIFICATIONS
Route::get('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
Route::get('notifications/read/{notification}', [NotificationController::class, 'read'])->name('notifications.read');
Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');

# BACKUP DATABASE
Route::resource('backup-databases', BackupDatabaseController::class);

# FILE MANAGER
Route::group(['prefix' => 'file-managers', 'middleware' => [FileManagerPermission::class]], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

# LOG VIEWER
Route::get('logs-viewer', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])->name('logs.index')->middleware('can:Laravel Log Viewer');

# YOUTUBE VIEWER (SECRET MENU)
Route::get('youtube-viewer', [YoutubeController::class, 'viewer'])->name('youtube.viewer');
Route::get('youtube-viewer-per-video', [YoutubeController::class, 'viewerPerVideo'])->name('youtube.viewer-per-video');

# UBUNTU
Route::get('ubuntu/laravel-seeder/{seeder}', [UbuntuController::class, 'laravelSeeder'])->name('ubuntu.laravelSeeder');
Route::get('ubuntu/laravel-migrate', [UbuntuController::class, 'laravelMigrate'])->name('ubuntu.laravelMigrate');
Route::get('ubuntu/laravel-migrate-refresh', [UbuntuController::class, 'laravelMigrateRefresh'])->name('ubuntu.laravelMigrateRefresh');
Route::get('ubuntu/supervisor/{action}', [UbuntuController::class, 'supervisor'])->name('ubuntu.supervisor');
Route::get('ubuntu/php-fpm/{version}/{action}', [UbuntuController::class, 'phpFpm'])->name('ubuntu.php-fpm');
Route::get('ubuntu/mysql/{action}', [UbuntuController::class, 'mysql'])->name('ubuntu.mysql');
Route::get('ubuntu/mysql/{database?}/{table?}/{action?}', [UbuntuController::class, 'index'])->name('ubuntu.mysql-paginate');
Route::get('ubuntu/edit-row/{database}/{table}/{id}', [UbuntuController::class, 'editRow'])->name('ubuntu.edit-row');
Route::put('ubuntu/update-row/{database}/{table}/{id}', [UbuntuController::class, 'updateRow'])->name('ubuntu.update-row');
Route::delete('ubuntu/delete-row/{database}/{table}/{id}', [UbuntuController::class, 'deleteRow'])->name('ubuntu.delete-row');
Route::get('ubuntu/nginx', [UbuntuController::class, 'nginx'])->name('ubuntu.nginx');
Route::post('ubuntu/create-database', [UbuntuController::class, 'createDb'])->name('ubuntu.create-db');
Route::get('ubuntu/{pathname}/toggle-ssl/{nextStatus}', [UbuntuController::class, 'toggleSSL'])->name('ubuntu.toggle-ssl');
Route::get('ubuntu/{pathname}/toggle-enabled/{nextStatus}', [UbuntuController::class, 'toggleEnabled'])->name('ubuntu.toggle-enabled');
Route::get('ubuntu/{pathname}/duplicate', [UbuntuController::class, 'duplicate'])->name('ubuntu.duplicate');
Route::get('ubuntu/{pathname}/git-pull', [UbuntuController::class, 'gitPull'])->name('ubuntu.git-pull');
Route::get('ubuntu/{pathname}/set-laravel-permission', [UbuntuController::class, 'setLaravelPermission'])->name('ubuntu.set-laravel-permission');
Route::resource('ubuntu', UbuntuController::class);

# MANAJEMEN MENU
// Route::get('menu-managements/pdf', [MenuManagementController::class, 'pdf'])->name('menu-managements.pdf');
// Route::get('menu-managements/csv', [MenuManagementController::class, 'csv'])->name('menu-managements.csv');
// Route::get('menu-managements/excel', [MenuManagementController::class, 'excel'])->name('menu-managements.excel');
// Route::get('menu-managements/json', [MenuManagementController::class, 'json'])->name('menu-managements.json');
// Route::get('menu-managements/import-excel-example', [MenuManagementController::class, 'importExcelExample'])->name('menu-managements.import-excel-example');
// Route::post('menu-managements/import-excel', [MenuManagementController::class, 'importExcel'])->name('menu-managements.import-excel');
Route::resource('menu-managements', MenuManagementController::class);
Route::resource('group-menus', GroupMenuController::class);

# CONTOH CRUD
Route::get('yajra-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-yajra');
Route::get('yajra-crud-examples/ajax', [CrudExampleController::class, 'yajraAjax'])->name('crud-examples.ajax-yajra');
Route::get('ajax-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-ajax');
Route::get('yajra-ajax-crud-examples', [CrudExampleController::class, 'index'])->name('crud-examples.index-ajax-yajra');
Route::get('crud-examples/pdf', [CrudExampleController::class, 'pdf'])->name('crud-examples.pdf');
Route::get('crud-examples/csv', [CrudExampleController::class, 'csv'])->name('crud-examples.csv');
Route::get('crud-examples/excel', [CrudExampleController::class, 'excel'])->name('crud-examples.excel');
Route::get('crud-examples/json', [CrudExampleController::class, 'json'])->name('crud-examples.json');
Route::get('crud-examples/import-excel-example', [CrudExampleController::class, 'importExcelExample'])->name('crud-examples.import-excel-example');
Route::post('crud-examples/import-excel', [CrudExampleController::class, 'importExcel'])->name('crud-examples.import-excel');
Route::resource('crud-examples', CrudExampleController::class);

Route::get('testing/datatable', [TestingController::class, 'datatable']);
Route::get('testing/send-email', [TestingController::class, 'sendEmail']);
Route::get('testing/modal', [TestingController::class, 'modal']);
