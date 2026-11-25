<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$about = \App\Models\About::first();
if ($about) {
    echo "visi: " . $about->visi . "\n";
    echo "misi: " . json_encode($about->misi) . "\n";
}
