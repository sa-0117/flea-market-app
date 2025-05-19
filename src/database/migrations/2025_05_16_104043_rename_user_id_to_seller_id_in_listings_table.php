<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUserIdToSellerIdInListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->renameColumn('user_id','seller_id');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->Foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('listings', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->renameColumn('seller_id','user_id');
        });

        Schema::table('listings', function (Blueprint $table) {
            $table->Foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
