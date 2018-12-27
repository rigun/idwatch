<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                  ->references('id')->on('users');
            $table->integer('status')->default(0);
            $table->double('shipping')->nullable();
            $table->string('provinsi')->nullable();
            $table->string('kota')->nullable();
            $table->string('type_shipping')->nullable();
            $table->string('service_shipping')->nullable();
            $table->string('estimate_shipping')->nullable();
            $table->double('total')->nullable();
            $table->string('notes')->nullable();
            $table->double('diskon')->nullable();
            $table->text('address')->nullable();
            $table->string('evidence')->nullable();
            $table->string('token');
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
        Schema::dropIfExists('transactions');
    }
}
