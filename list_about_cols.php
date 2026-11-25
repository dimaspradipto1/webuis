<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$cols = \Illuminate\Support\Facades\Schema::getColumnListing('abouts');
print_r($cols);
