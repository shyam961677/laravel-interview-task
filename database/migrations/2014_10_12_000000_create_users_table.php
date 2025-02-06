<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            // $table->string('name');
            // $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            // $table->string('image')->nullable();
            // $table->string('mobile')->nullable();
            // $table->date('date')->nullable(); // e.g. date of birth
            $table->enum('role', ['Admin', 'User'])->default('User');
            $table->timestamps();
        });

        $SQL = 'ALTER TABLE `users` ADD `name` VARBINARY(191) NULL AFTER `id`, ADD `email` VARBINARY(191) NULL AFTER `name`, ADD `image` VARBINARY(191) NULL AFTER `email`, ADD `mobile` VARBINARY(191) NULL AFTER `image`, ADD `date` VARBINARY(191) NULL AFTER `mobile`';

        \DB::statement($SQL);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
