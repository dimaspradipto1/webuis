<?php

use App\Models\Milestone;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        foreach (Milestone::all() as $milestone) {
            $milestone->deskripsi = Milestone::cleanTextWithLineBreaks($milestone->deskripsi);
            $milestone->saveQuietly();
        }
    }

    public function down(): void
    {
        //
    }
};

