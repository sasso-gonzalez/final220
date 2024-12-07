<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); //'user_id'
            $table->string('first_name');
            $table->string('last_name');
            $table->string('role'); // foreign key column
            $table->string('phone')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('family_code')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('relation_emergency_contact')->nullable();
            $table->string('status')->default('pending'); //added
            $table->timestamps();

            $table->foreign('role')->references('role')->on('roles')->onDelete('cascade');

        });
    }
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role']); // drops foreign key constraint -serena
        });
    
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['first_name', 'last_name', 'role', 'phone', 'date_of_birth','family_code','emergency_contact','relation_emergency_contact', 'status']); //added user_id -serena (11/20)
        });
    }
    
};


//$table->string('role')->default('user');
