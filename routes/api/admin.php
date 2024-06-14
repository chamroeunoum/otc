<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\PeopleController;
use App\Http\Controllers\Api\Admin\FolderController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\Regulator\RegulatorController;
use App\Http\Controllers\Api\Admin\Regulator\LegalDraftController;
use App\Http\Controllers\Api\Admin\Regulator\RegulatorParentController;
use App\Http\Controllers\Api\Admin\Regulator\TypeController;
use App\Http\Controllers\Api\Admin\Regulator\OrganizationController;
use App\Http\Controllers\Api\Admin\Regulator\CountesyController;
use App\Http\Controllers\Api\Admin\Regulator\PositionController;
use App\Http\Controllers\Api\Admin\Regulator\SignatureController;
use App\Http\Controllers\Api\Admin\ProfileController;

use App\Http\Controllers\Api\Admin\Law\Book\BookController;
use App\Http\Controllers\Api\Admin\Law\Book\KuntyController;
use App\Http\Controllers\Api\Admin\Law\Book\MatikaController;
use App\Http\Controllers\Api\Admin\Law\Book\PartController;
use App\Http\Controllers\Api\Admin\Law\Book\SectionController;
use App\Http\Controllers\Api\Admin\Law\Book\MatraController;
use App\Http\Controllers\Api\Admin\Law\Book\TypeController AS BookTypeController;


Route::group([
    'prefix' => 'admin' ,
    'api'
  ],function(){

    /** SIGNING SECTION */
    Route::group([
        'prefix' => 'authentication'
    ], function () {
        Route::post('login', [AuthController::class,'login']);
        Route::group([
        'middleware' => 'auth:api'
        ], function() {
            Route::post('logout', [AuthController::class,'logout']);
            Route::get('user', [AuthController::class,'user']);
        });
    });

    /** USER/ACCOUNT SECTION */
    Route::group([
        'prefix' => 'users' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[UserController::class,'index']);
            Route::post('create',[UserController::class,'store']);
            Route::put('update',[UserController::class,'update']);
            Route::put('authenticated',[ProfileController::class,'updateAuthUser']);
            Route::get('{id}/read',[UserController::class,'read']);
            Route::delete('{id}/delete',[UserController::class,'destroy']);
            Route::put('activate',[UserController::class,'active']);
            Route::put('password/change',[UserController::class,'passwordChange']);
            /**
             * Check the unique user information
             */
            Route::get('username/exist',[UserController::class,'checkUsername']);
            Route::get('phone/exist',[UserController::class,'checkPhone']);
            Route::get('email/exist',[UserController::class,'checkEmail']);
            Route::post('upload',[UserController::class,'upload']);
    });

    /** PEOPLE / USER INFORMATION SECTION */
    Route::group([
        'prefix' => 'people' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[PeopleController::class,'index']);
            Route::post('create',[PeopleController::class,'store']);
            Route::put('update',[PeopleController::class,'update']);
            Route::get('{id}/read',[PeopleController::class,'read']);
            Route::delete('{id}/delete',[PeopleController::class,'destroy']);
    });

    /** PEOPLE / USER INFORMATION SECTION */
    Route::group([
        'prefix' => 'people' ,
        'namespace' => 'Api' ,
        'middleware' => 'api'
        ], function() {
            Route::get('{id}/read',[PeopleController::class,'read']);
    });

    /** FOLDER SECTION */
    Route::group([
        'prefix' => 'folders' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[FolderController::class,'index']);
            Route::post('create',[FolderController::class,'store']);
            Route::put('update',[FolderController::class,'update']);
            Route::get('{id}/read',[FolderController::class,'read']);
            Route::delete('{id}/delete',[FolderController::class,'destroy']);
            Route::put('activate',[FolderController::class,'active']);
            /**
             * Check the unique user information
             */
            Route::get('subfolders',[FolderController::class,'getSubfolders']);
            Route::get('regulators',[FolderController::class,'getRegulators']);

            Route::get('regulators',[ FolderController::class , 'regulators']);
            Route::put('regulators/add',[ FolderController::class , 'addRegulatorToFolder']);
            Route::put('regulators/remove',[ FolderController::class , 'removeRegulatorFromFolder']);
            Route::put('regulators/check',[ FolderController::class , 'checkRegulator']);
            Route::get('user',[ FolderController::class , 'user']);
            Route::get('list/regulator/validation',[ FolderController::class , 'listFolderWithRegulatorValidation']);

            Route::put('{id}/accessibility',[FolderController::class,'accessibility']);

    });

    /** ORGANIZATION SECTION */
    Route::group([
        'prefix' => 'organizations' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[OrganizationController::class,'index']);
            Route::get('compact',[OrganizationController::class,'compact']);
            Route::get('listbyparent',[OrganizationController::class,'listByParent']);
            Route::post('create',[OrganizationController::class,'store']);
            Route::post('addchild',[OrganizationController::class,'addChild']);
            Route::put('update',[OrganizationController::class,'update']);
            Route::get('{id}/read',[OrganizationController::class,'read']);
            Route::delete('{id}/delete',[OrganizationController::class,'destroy']);
            Route::put('activate',[OrganizationController::class,'active']);
            Route::put('deactivate',[OrganizationController::class,'unactive']);
            /**
             * Check the unique user information
             */
            Route::get('children',[OrganizationController::class,'getChildren']);
            Route::get('regulators',[OrganizationController::class,'getRegulators']);
            Route::get('staffs',[ OrganizationController::class , 'staffs']);
            Route::get('{id}/people',[ OrganizationController::class , 'people']);
            Route::put('setleader',[ OrganizationController::class , 'setLeader']);
            Route::put('addstaff',[ OrganizationController::class , 'addPeopleToOrganization']);
    });

    /** POSITION SECTION */
    Route::group([
        'prefix' => 'positions' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[PositionController::class,'index']);
            Route::get('compact',[PositionController::class,'compact']);
            Route::get('listbyparent',[PositionController::class,'listByParent']);
            Route::post('create',[PositionController::class,'store']);
            Route::post('addchild',[PositionController::class,'addChild']);
            Route::put('update',[PositionController::class,'update']);
            Route::get('{id}/read',[PositionController::class,'read']);
            Route::delete('{id}/delete',[PositionController::class,'destroy']);
            Route::put('activate',[PositionController::class,'active']);
            Route::put('deactivate',[PositionController::class,'unactive']);
            /**
             * Check the unique user information
             */
            Route::get('children',[PositionController::class,'getChildren']);
            Route::get('regulators',[PositionController::class,'getRegulators']);
            Route::get('staffs',[ PositionController::class , 'staffs']);
            Route::get('{id}/people',[ PositionController::class , 'people']);
            Route::put('setleader',[ PositionController::class , 'setLeader']);
            Route::put('addstaff',[ PositionController::class , 'addPeopleToPosition']);
    });

    /** COUNTESY SECTION */
    Route::group([
        'prefix' => 'countesies' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[CountesyController::class,'index']);
            Route::post('create',[CountesyController::class,'store']);
            Route::put('update',[CountesyController::class,'update']);
            Route::get('{id}/read',[CountesyController::class,'read']);
            Route::delete('{id}/delete',[CountesyController::class,'destroy']);
            Route::put('activate',[CountesyController::class,'active']);
    });

    /** ROLE SECTION */
    Route::group([
        'prefix' => 'roles' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {
            Route::get('',[RoleController::class,'index']);
            Route::post('create',[RoleController::class,'store']);
            Route::put('update',[RoleController::class,'update']);
            Route::get('{id}/read',[RoleController::class,'read']);
            Route::delete('{id}/delete',[RoleController::class,'destroy']);
    });

    // I am here , please continue to the below lines

    /** REGULATOR SECTION */
    Route::group([
        'prefix' => 'regulators' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {;
            Route::get('',[RegulatorController::class,'index']);
            Route::get('child',[RegulatorController::class,'child']);
            Route::get('read',[RegulatorController::class,'read']);
            Route::post('',[RegulatorController::class,'create']);
            Route::put('',[RegulatorController::class,'update']);
            Route::put('{id}/activate',[RegulatorController::class,'activate']);
            Route::put('{id}/deactivate',[RegulatorController::class,'deactivate']);
            Route::delete('',[RegulatorController::class,'destroy']);
            Route::post('upload',[RegulatorController::class,'upload']);
            

            // Route::get('get/regulator/years','RegulatorController@getYears');
            Route::get('pdf',[RegulatorController::class,'pdf']);
            // Route::get('types/compact', "TypeController@compactList");
            Route::group([
                'prefix' => 'types' ,
                ], function() {
                    Route::get('compact', [TypeController::class,'compact']);
            });
            Route::group([
                'prefix' => 'signatures' ,
                ], function() {
                    Route::get('compact', [SignatureController::class,'compact']);
            });
            Route::group([
                'prefix' => 'organizations' ,
                ], function() {
                    Route::get('compact', [OrganizationController::class,'compact']);
            });

            Route::put('addreader',[RegulatorController::class,'addReaders']);
            Route::put('removereader',[RegulatorController::class,'removeReaders']);
            Route::put('{id}/accessibility',[RegulatorController::class,'accessibility']);
            
            Route::group([
                'prefix' => 'oknha'
                ], function(){
                    Route::get('', [RegulatorController::class,'oknha'] );
                }
            );

    });

    /** LEGAL DRAFT SECTION */
    Route::group([
        'prefix' => 'legaldrafts' ,
        'namespace' => 'Api' ,
        'middleware' => 'auth:api'
        ], function() {;
            Route::get('',[LegalDraftController::class,'index']);
            Route::get('read',[LegalDraftController::class,'read']);
            Route::post('',[LegalDraftController::class,'create']);
            Route::put('',[LegalDraftController::class,'update']);
            Route::delete('',[LegalDraftController::class,'destroy']);
            // Route::post('upload',[LegalDraftController::class,'upload']);
    });

    Route::group([
        'prefix' => 'orgchart' ,
        'namespace' => 'Api' ,
        'middleware' => 'api'
        ], function() {;
            Route::get('',[RegulatorParentController::class,'index']);
            Route::get('child',[RegulatorParentController::class,'child']);
            Route::get('read',[RegulatorParentController::class,'read']);
            Route::post('',[RegulatorParentController::class,'create']);
            Route::put('',[RegulatorParentController::class,'update']);
            Route::put('linkregulator',[RegulatorParentController::class,'linkRegulator']);
            Route::delete('',[RegulatorParentController::class,'destroy']);
    });

    // Route::group([
    //     'prefix' => 'organizations' ,
    //     ], function() {
    //         Route::get('',[OrganizationController::class,'index']);
    //         Route::get('compact', [OrganizationController::class,'compact']);
    //         Route::get('read',[OrganizationController::class,'read']);
    //         Route::post('',[OrganizationController::class,'create']);
    //         Route::put('',[OrganizationController::class,'update']);
    //         Route::put('{id}/activate',[OrganizationController::class,'activate']);
    //         Route::put('{id}/deactivate',[OrganizationController::class,'deactivate']);
    //         Route::delete('',[OrganizationController::class,'destroy']);

    //         Route::get('child',[OrganizationController::class,'child']);
    //         Route::post('upload',[OrganizationController::class,'upload']);
            
    // });

    // Route::group([
    //     'prefix' => 'positions' ,
    //     ], function() {
    //         Route::get('',[PositionController::class,'index']);
    //         Route::get('compact', [PositionController::class,'compact']);
    //         Route::get('read',[PositionController::class,'read']);
    //         Route::post('',[PositionController::class,'create']);
    //         Route::put('',[PositionController::class,'update']);
    //         Route::put('{id}/activate',[PositionController::class,'activate']);
    //         Route::put('{id}/deactivate',[PositionController::class,'deactivate']);
    //         Route::delete('',[PositionController::class,'destroy']);

    //         Route::get('child',[PositionController::class,'child']);
    //         Route::post('upload',[PositionController::class,'upload']);
            
    // });

    /** FOLDER SECTION */
    // Route::group([
    //     'prefix' => 'folders' ,
    //     'namespace' => 'Api' ,
    //     'middleware' => 'auth:api'
    //     ], function() {
    //         Route::get('list','FolderController@index');
    //         Route::get('{folderId}/regulator/{regulatorId}/add','FolderController@addRegulatorToFolder');
    //         Route::get('{folderId}/regulator/{regulatorId}/remove','FolderController@removeRegulatorToFolder');
    //         Route::put('checkregulator','FolderController@checkRegulator');
    //         Route::put('delete','FolderController@delete');
    //         Route::post('store','FolderController@store');
    //         Route::get('user','FolderController@user');
    // });
    /** SECTION OF DOCUMENT TYPE */
    // Route::group([
    //     'prefix' => 'types' ,
    //     'namespace' => 'Api' ,
    //     'middleware' => 'auth:api'
    //     ], function() {
    //         Route::get('','TypeController@index');
    // });

    /** SECTION OF MINISTRY */
    // Route::group([
    //     'prefix' => 'ministries' ,
    //     'namespace' => 'Api' ,
    //     'middleware' => 'auth:api'
    //     ], function() {
    //         Route::get('','MinistryController@index');
    // });

    /** PROFILE SECTION */
    // Route::group([
    //     'prefix' => 'profile',
    //     'namespace' => 'Api' ,
    //     'middleware' => 'auth:api'
    // ], function() {
    //     Route::get('/getAuthUser',
    //                 'ProfileController@getAuthUser');
    //     Route::put('/updateAuthUser',
    //                 'ProfileController@updateAuthUser');
    //     Route::put('/updateAuthUserPassword',
    //                 'ProfileController@updateAuthUserPassword');
    //     Route::post('/picture/upload','ProfileController@upload');
    // });

    Route::group([
        'prefix' => 'tasks',
        'namespace' => 'tasks' ,
        'middleware' => 'auth:api'
    ],function(){
        /**
         * Methods to apply for each of the CRUD operations
         * Create => POST
         * Read => GET
         * Update => PUT
         * Delete => DELETE
         */
    
        /**
         * Get all records
         */
        Route::get('',"TaskController@index")->name("taskList");
        /**
         * Get a record with id
         */
        Route::get('{id}/read',"TaskController@read")->name("taskRead");
        /**
         * Create a record
         */
        Route::post('',"TaskController@create")->name("taskCreate");
        /**
         * Update a reccord with id
         */
        Route::put('',"TaskController@update")->name("taskUpdate");
        /**
         * Delete a record
         */
        Route::delete('users',"TaskController@delete")->name("taskDelete");
    
        /**
         * Activate, Deactivate account
         */
        Route::put('activate','TaskController@activate')->name('taskActivate');
        Route::put('deactivate','TaskController@deactivate')->name('taskDeactivate');
    
        Route::put('start','TaskController@startTask')->name('taskStart');
        Route::put('end','TaskController@endTask')->name('taskEnd');
        Route::put('pending','TaskController@pendingTask')->name('taskPending');
        Route::put('continue','TaskController@continueTask')->name('taskContinue');
        /**
         * Get number of the tasks base on it status
         */
        Route::get('total_number_of_each_status',function(Request $request){
            return response()->json([
                'new' => \App\Models\Task\Task::getTotalNewTasks() ,
                'in_progress' => \App\Models\Task\Task::getTotalInProgressTasks() ,
                'pending' => \App\Models\Task\Task::getTotalPendingTasks() ,
                'ended' => \App\Models\Task\Task::getTotalEndedTasks()
            ],200);
        });
        Route::get('total_number_of_new',function(Request $request){
            return \App\Models\Task\Task::getTotalNewTasks();
        });
        Route::get('total_number_of_in_progress',function(Request $request){
            return \App\Models\Task\Task::getTotalInProgressTasks();
        });
        Route::get('total_number_of_pending',function(Request $request){
            return \App\Models\Task\Task::getTotalPendingTasks();
        });
        Route::get('total_number_of_ended',function(Request $request){
            return \App\Models\Task\Task::getTotalEndedTasks();
        });
        /**
         * Get total earn
         */
        Route::get('total_earn',function(){
            return \App\Models\Task\Task::getTotalEarn();
        });
        Route::get('total_earn_by_month_of_year/{date}',function(){
            return \App\Models\Task\Task::getTotalEarn($date);
        });
        Route::get('total_earn_between/{start}/{end}',function(){
            return \App\Models\Task\Task::getTotalEarn($start,$end);
        });
        /**
         * Get total expense
         */
        Route::get('total_expense',function(){
            return \App\Models\Task\Task::getTotalExpense();
        });
        Route::get('total_expense_by_month_of_year/{date}',function(){
            return \App\Models\Task\Task::getTotalExpenseByMonthOfYear($date);
        });
        Route::get('total_expense_between/{start}/{end}',function(){
            return \App\Models\Task\Task::getTotalExpenseBetween($start,$end);
        });
        /**
         * Get total expense and earn
         */
        /**
         * Total tasks, expense, earn by day
         */
        Route::get('total_tasks_earn_expense',function(Request $request){
            return response()->json([
                'new' => \App\Models\Task\Task::getTotalNewTasks() ,
                'progress' => \App\Models\Task\Task::getTotalInProgressTasks() ,
                'pending' => \App\Models\Task\Task::getTotalPendingTasks() ,
                'ended' => \App\Models\Task\Task::getTotalEndedTasks() ,
                'earn' => \App\Models\Task\Task::getTotalEarn() ,
                'expense' => \App\Models\Task\Task::getTotalExpense()
            ],200);
        });
        Route::get('total_tasks_earn_expense_by_day',function(Request $request){
            return response()->json([
                'new' => \App\Models\Task\Task::getNewTasks()->where('created_at','like',\Carbon\Carbon::now()->format('Y-m-d')."%")->count() ,
                'progress' => \App\Models\Task\Task::getInProgressTasks()->where('created_at','like',\Carbon\Carbon::now()->format('Y-m-d')."%")->count() ,
                'pending' => \App\Models\Task\Task::getPendingTasks()->where('created_at','like',\Carbon\Carbon::now()->format('Y-m-d')."%")->count() ,
                'ended' => \App\Models\Task\Task::getEndedTasks()->where('created_at','like',\Carbon\Carbon::now()->format('Y-m-d')."%")->count() ,
                'earn' => number_format( \App\Models\Task\Task::getTotalEarnBetween(\Carbon\Carbon::now()->format('Y-m-d'),\Carbon\Carbon::now()->format('Y-m-d'))->sum('total'),2,'.',',' ) ,
                'expense' => number_format( \App\Models\Task\Task::getTotalExpenseBetween(\Carbon\Carbon::now()->format('Y-m-d'),\Carbon\Carbon::now()->format('Y-m-d'))->sum('total'),2,'.',',' )
            ],200);
        });
    });

    require( 'admin/attendant.php' );
    require( 'admin/book.php' );
    require( 'admin/task.php' );

});
