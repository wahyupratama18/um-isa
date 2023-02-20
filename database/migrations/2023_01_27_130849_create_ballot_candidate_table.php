<?php

use App\Models\Ballot;
use App\Models\Candidate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ballot_candidate', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Ballot::class)
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->foreignIdFor(Candidate::class)
            ->nullable()
            ->constrained()
            ->cascadeOnUpdate()
            ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ballot_candidate');
    }
};
