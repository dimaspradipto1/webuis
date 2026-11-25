<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$about = \App\Models\About::first();
if ($about) {
    echo "visi: " . $about->visi . "\n";
    echo "misi: " . $about->misi . "\n";
    echo "judul_nilai: " . $about->judul_nilai . "\n";
    echo "nilai_1: " . $about->nilai_1_judul . " - " . $about->nilai_1_deskripsi . "\n";
}
