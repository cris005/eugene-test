<?php

use App\Models\Doctor;
use App\Models\Test;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Uid\Ulid;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('tests', function (Blueprint $table) {
            $table->ulid()->after('id')->nullable();
        });
        $this->insertUlids();

        // Once all tests have ULIDs, make the column have a unique index
        Schema::table('tests', function (Blueprint $table) {
            $table->ulid()->after('id')->unique()->change();
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
        $tests = Test::where(['ulid' => null])->get();
        foreach ($tests as $test) {
            $test->update(['ulid' => Ulid::generate()]);
        }
    }
};
