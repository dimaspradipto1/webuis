<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$about = \App\Models\About::first();
echo "tagline_visi: " . ($about->visimisi_tagline_visi ?? 'EMPTY') . "\n";
echo "misi_items: " . ($about->visimisi_misi_items ?? 'EMPTY') . "\n";
echo "tatanilai_items: " . ($about->visimisi_tatanilai_items ?? 'EMPTY') . "\n";
echo "background: " . ($about->visimisi_background ?? 'EMPTY') . "\n";
