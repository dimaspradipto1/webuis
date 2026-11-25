<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
$all = \App\Models\VisiMisi::all();
foreach ($all as $item) {
    echo "ID: {$item->id} | Judul: {$item->judul} | Tipe: {$item->tipe} | Gambar: {$item->gambar} | Keterangan: {$item->keterangan}\n";
    echo "Isi: {$item->isi}\n---\n";
}
