<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

// Test frontend /visi-misi
$req = \Illuminate\Http\Request::create('/visi-misi', 'GET');
$res = $kernel->handle($req);
echo "FRONTEND /visi-misi: " . $res->getStatusCode() . "\n";

// Test admin /visimisi with auth
$user = \App\Models\User::first();
\Illuminate\Support\Facades\Auth::login($user);
$reqAdmin = \Illuminate\Http\Request::create('/visimisi', 'GET');
$resAdmin = $kernel->handle($reqAdmin);
echo "ADMIN /visimisi: " . $resAdmin->getStatusCode() . "\n";
