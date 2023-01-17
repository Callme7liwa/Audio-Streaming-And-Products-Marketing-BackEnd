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
        Schema::create('friends', function (Blueprint $table) {
            $table->unsignedBigInteger('follower_profile_id');
            $table->unsignedBigInteger('followed_profile_id');
            $table->primary(['follower_profile_id', 'followed_profile_id']);
            $table->timestamps();
    
            $table->foreign('follower_profile_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('followed_profile_id')->references('id')->on('users')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('friends');
    }
};
