<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $stats = DB::table('faculty_stats')->get();
        foreach ($stats as $stat) {
            if (! empty($stat->title) && stripos($stat->title, 'FIKES') !== false) {
                $newTitle = trim(preg_replace('/\bFIKES\b\s*/i', '', $stat->title)) ?: 'UIS Dalam Angka';
                DB::table('faculty_stats')->where('id', $stat->id)->update(['title' => $newTitle]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};

