<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResources([
    'companies' => CompanyController::class,
    'products' => ProductController::class,
    'experiences' => ExperienceController::class,
    'techs' => TechController::class,
]);

