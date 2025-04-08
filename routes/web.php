<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controllerblade\UserController;
use App\Http\Controllers\Controllerblade\LevelController;
use App\Http\Controllers\Controllerblade\LevelUserController;
use App\Http\Controllers\Controllerblade\ModuleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Controllerblade\FeedController;
use App\Http\Controllers\Controllerblade\DailyActivityController;
use App\Http\Controllers\Controllerblade\UserActivityController;
use App\Http\Controllers\Controllerblade\ArticleController;
use App\Http\Controllers\Controllerblade\landingPageController;
use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\Controllerblade\SoalQuiz;
use App\Http\Controllers\Controllerblade\QuizController;
use App\Http\Controllers\Controllerblade\VideoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [landingPageController::class, 'getActivity']);
Route::get('/login',[LoginController::class,'showLogin'])->name('login');
Route::post('/login',[LoginController::class,'login']);


Route::middleware(['auth'])->group(function(){
    Route::post('/logout',[LoginController::class,'logout']);

    Route::prefix('/user')->group(function(){
        Route::get('/profile', [landingPageController::class, 'getProfile']);
        Route::get('/home', [landingPageController::class, 'home']);
        Route::prefix('/materi')->group(function(){
            Route::get('/', [landingPageController::class, 'materi'])->name('materi');
            Route::get('/{id}', [landingPageController::class, 'materi']);
        });
        
    });

    //admin
    Route::prefix('/admin')->group(function(){

        Route::middleware(['userAcess:superadmin'])->group(function(){
            Route::prefix('/master')->group(function(){

           
        
                Route::prefix('/user')->group(function(){
                    Route::get('/', [Usercontroller::class,'index'])->name('user');
                    Route::get('/suting/{id}', [UserController::class, 'edit']);
                    Route::post('/add',[Usercontroller::class,'store']);
                    Route::put('/edit/{id}',[Usercontroller::class, 'update']);
                    Route::delete('/delete/{id}',[Usercontroller::class, 'destroy']);
                });
                
                Route::prefix('/level')->group(function(){
                    Route::get('/list', [LevelController::class,'index'])->name('level');
                    Route::post('/add',[LevelController::class,'store']);
                    Route::put('/edit/{id}', [LevelController::class, 'update']);
                    Route::delete('/delete/{id}',[LevelController::class,'destroy']);
                    Route::get('/user', [LevelUserController::class,'index']);
                    Route::put('/user/edit', [LevelUserController::class,'updateLevels']);
                    Route::post('/reoder',[LevelController::class,'updateUrutan']);
                });
        
                Route::prefix(('daily_activity'))->group(function(){
                    Route::get('/', [DailyActivityController::class,'index'])->name('daily_activity');
                    Route::post('/add', [DailyActivityController::class,'store']);
                    Route::put('/update/{id}', [DailyActivityController::class,'update']);
                    Route::delete('/delete/{id}', [DailyActivityController::class,'destroy']);
                });
            
            });
        });
      

        route::middleware(['userAcess:superadmin|teacher'])->group(function(){

            Route::prefix('/module')->group(function(){
                Route::get('/', [ModuleController::class,'index'])->name('module');
                Route::post('/add', [ModuleController::class,'store']);
                Route::put('/update/{id}', [ModuleController::class,'update']);
                Route::delete('/delete/{id}', [ModuleController::class,'destroy']);
            });
        
            Route::prefix('/feed')->group(function(){
                Route::get('/', [FeedController::class,'index'])->name('feed');
                Route::post('/add', [FeedController::class,'store']);
                Route::put('/update/{id}', [FeedController::class,'update']);
                Route::delete('/delete/{id}', [FeedController::class,'destroy']);
            });
        
            Route::prefix('/user_activity')->group(function(){
                Route::get('/', [UserActivityController::class, 'user']);
                Route::get('/activity/{id}', [UserActivityController::class, 'activity']);
                Route::post('/generate/daily', [UserActivityController::class, 'generateDailyActivity']);
                Route::post('/generate/monthly', [UserActivityController::class, 'generateMonthlyReport']);
            });
        
            Route::prefix('article')->group(function(){
                Route::get('/', [ArticleController::class, 'index'])->name('article');
                Route::get('/edit/{id}', [ArticleController::class, 'edit']);
                Route::get('/create', [ArticleController::class, 'create']);
                Route::post('/store', [ArticleController::class, 'store']);
                Route::put('/update/{id}', [ArticleController::class, 'update']);
                Route::delete('/delete/{id}', [ArticleController::class, 'destroy']);
                Route::post('/upload-image', [ImageUploadController::class, 'imageUploadArticle'])->middleware('web');
                Route::post('/delete-image', [ImageUploadController::class, 'deleteImage'])->middleware('web');
            });
        
            Route::prefix('quiz')->group(function(){
                Route::get('/', [QuizController::class, 'index'])->name('quiz');
                Route::get('/edit/{id}', [QuizController::class, 'edit']);
                Route::get('/create', [QuizController::class, 'create']);
                Route::post('/store', [QuizController::class, 'store']);
                Route::put('/update/{id}', [QuizController::class, 'update']);
                Route::delete('/delete/{id}', [QuizController::class, 'destroy']);
            });
        
            Route::prefix('soal')->group(function(){
                Route::post('/store', [SoalQuiz::class, 'store']);
                Route::delete('/delete-soal/{id}', [SoalQuiz::class, 'destroySoal'])->name('delete-soal');
                Route::delete('/delete-opsi/{id}', [SoalQuiz::class, 'destroyOpsi'])->name('delete-opsi');
            });
    
            Route::prefix('/video')->group(function(){
                Route::get('/', [VideoController::class, 'index']);
                Route::post('/store', [VideoController::class, 'store']);
                Route::put('/update/{id}', [VideoController::class, 'update']);
                Route::delete('/delete/{id}', [VideoController::class, 'destroy']);
            });
        });
        
    });

});