<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Support;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('total_price', 10, 2)->after('price')->default(0);
        });
    }

    public function down()
    {
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropColumn('total_price');
        });
    }
};