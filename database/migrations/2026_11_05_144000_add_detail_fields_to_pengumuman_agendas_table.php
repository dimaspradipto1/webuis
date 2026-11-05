<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pengumuman_agendas', function (Blueprint $table) {
            if (! Schema::hasColumn('pengumuman_agendas', 'slug')) {
                $table->string('slug')->nullable()->unique()->after('judul');
            }
            if (! Schema::hasColumn('pengumuman_agendas', 'konten')) {
                $table->longText('konten')->nullable()->after('waktu');
            }
            if (! Schema::hasColumn('pengumuman_agendas', 'lokasi')) {
                $table->string('lokasi')->nullable()->after('konten');
            }
            if (! Schema::hasColumn('pengumuman_agendas', 'foto')) {
                $table->string('foto')->nullable()->after('lokasi');
            }
            if (! Schema::hasColumn('pengumuman_agendas', 'galeri')) {
                $table->json('galeri')->nullable()->after('foto');
            }
            if (! Schema::hasColumn('pengumuman_agendas', 'file_lampiran')) {
                $table->string('file_lampiran')->nullable()->after('galeri');
            }
        });

        $items = DB::table('pengumuman_agendas')->get();
        foreach ($items as $item) {
            $slug = Str::slug($item->judul) . '-' . $item->id;
            $defaultKonten = $item->tipe === 'pengumuman'
                ? '<p>Diberitahukan kepada seluruh mahasiswa dan sivitas akademika <strong>Universitas Ibnu Sina (UIS)</strong> terkait <strong>' . e($item->judul) . '</strong> yang dijadwalkan pada <strong>' . e($item->waktu) . '</strong>.</p><p>Sehubungan dengan hal tersebut, diharapkan kepada seluruh mahasiswa untuk memperhatikan jadwal dan prosedur pelaksanaan sesuai ketentuan akademik yang berlaku melalui portal SIAKAD maupun bagian akademik fakultas masing-masing.</p>'
                : '<p>Agenda kegiatan akademik <strong>' . e($item->judul) . '</strong> Universitas Ibnu Sina dijadwalkan berlangsung pada periode <strong>' . e($item->waktu) . '</strong>.</p><p>Seluruh mahasiswa dan dosen diharapkan mempersiapkan kelengkapan administrasi dan mengikuti rangkaian agenda tepat waktu sesuai kalender akademik universitas.</p>';

            DB::table('pengumuman_agendas')->where('id', $item->id)->update([
                'slug' => $item->slug ?: $slug,
                'konten' => $item->konten ?: $defaultKonten,
                'lokasi' => $item->lokasi ?: ($item->tipe === 'pengumuman' ? 'Bagian Akademik & Portal SIAKAD UIS' : 'Kampus Universitas Ibnu Sina Batam'),
            ]);
        }
    }

    public function down(): void
    {
        Schema::table('pengumuman_agendas', function (Blueprint $table) {
            $cols = ['slug', 'konten', 'lokasi', 'foto', 'galeri', 'file_lampiran'];
            foreach ($cols as $col) {
                if (Schema::hasColumn('pengumuman_agendas', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};

