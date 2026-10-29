<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes (Global & Auth)
|--------------------------------------------------------------------------
|
| Rute autentikasi global aplikasi.
| Seluruh rute modul aplikasi (HMVC) kini dikelola secara mandiri dan modular
| di dalam: app/Modules/{NamaModul}/Routes/web.php
| yang dimuat secara otomatis oleh App\Providers\ModuleServiceProvider.
|
*/

Auth::routes();