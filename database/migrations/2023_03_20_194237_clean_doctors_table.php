<?php

use App\Models\Doctor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;

return new class extends Migration {
    public function up(): void
    {
        Artisan::call('db:seed', [
            '--class' => 'SpecialtiesTableSeeder',
            '--force' => true
        ]);

        Artisan::call('db:seed', [
            '--class' => 'ClinicsTableSeeder',
            '--force' => true
        ]);

        // NOTE: SQLite only allows 1 modification per DB transaction, so we must split the workflow
        Schema::table('doctors', function (Blueprint $table) {
            $table->ulid()->after('id')->nullable();
        });
        $this->insertUlids();

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('specialty');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('clinic_name');
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('clinic_address');
        });

        // Once all doctors have ULIDs, make the column have a unique index
        Schema::table('doctors', function (Blueprint $table) {
            $table->ulid()->unique()->change();
        });
    }

    /**
     * Will recreate the deleted columns but there will be data loss
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn('ulid');
            $table->string('specialty')->nullable();
            $table->string('clinic_name')->nullable();
            $table->string('clinic_address')->nullable();
        });
    }

    /**
     * Insert an ULID for each doctor that doesn't already have one
     *
     * @return void
     */
    public function insertUlids(): void
    {
        $doctors = Doctor::where(['ulid' => null])->get();
        foreach ($doctors as $doctor) {
            $doctor->update(['ulid' => Ulid::generate()]);
        }
    }
};
