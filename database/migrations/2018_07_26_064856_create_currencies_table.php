<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('code', 50)->unique()->comment('Mã tiền tệ')->index();
            $table->float('value', 16, 4)->comment('1 USD bằng bao nhiêu tiền này');
            $table->string('symbol_left', '50');      
            $table->string('symbol_right', '50');
            $table->enum('seperator', [ 'space', 'comma', 'dot' ]);
            $table->tinyInteger('decimal');
            $table->boolean('status')->default(true)->index();
            $table->boolean('fiat')->default(true);
            $table->boolean('default')->default(false);
            $table->boolean('homepage')->default(false)->comment('Có cho hiện trên trang chủ hay ko')->index();
            $table->tinyInteger('sort');
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
        Schema::dropIfExists('currencies');
    }
}
