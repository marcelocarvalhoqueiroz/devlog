<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\TechController;

Route::apiResources([
    'companies' => CompanyController::class,
    'products' => ProductController::class,
    'experiences' => ExperienceController::class,
    'techs' => TechController::class,
]);

