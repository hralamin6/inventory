<?php

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
        Schema::create('setups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable()->default('sample name');
            $table->string('designation')->nullable()->default('sample designation');
            $table->string('site_name')->nullable()->default('Site name');
            $table->string('site_url')->nullable()->default('https://sample.com');
            $table->string('phone')->nullable()->default('01472583698');
            $table->string('phone_two')->nullable()->default('01472569856');
            $table->date('date_of_birth')->nullable()->default(today());
            $table->string('email')->nullable()->default('seewerer@gmail.com');
            $table->string('email_two')->nullable()->default('asdfje@gmail.com');
            $table->string('location')->nullable()->default('dhaka, Bangladesh');
            $table->string('facebook')->nullable()->default('http://facebook.com');
            $table->string('twitter')->nullable()->default('http://twitter.com');
            $table->string('youtube')->nullable()->default('http://youtube.com');
            $table->string('github')->nullable()->default('http://gitbub.com');
            $table->string('about')->nullable()->default('asdfa saerawerfasdfadsf');
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
        Schema::dropIfExists('setups');
    }
};
