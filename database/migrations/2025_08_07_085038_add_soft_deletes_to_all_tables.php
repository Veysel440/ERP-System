<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function ($table) {
            $table->softDeletes();
        });
        Schema::table('purchases', function ($table) {
            $table->softDeletes();
        });
        Schema::table('projects', function ($table) {
            $table->softDeletes();
        });
        Schema::table('tasks', function ($table) {
            $table->softDeletes();
        });
        Schema::table('finance_transactions', function ($table) {
            $table->softDeletes();
        });
        Schema::table('users', function ($table) {
            $table->softDeletes();
        });
        Schema::table('products', function ($table) {
            $table->softDeletes();
        });
        Schema::table('suppliers', function ($table) {
            $table->softDeletes();
        });
        Schema::table('departments', function ($table) {
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::table('employees', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('purchases', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('projects', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('tasks', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('finance_transactions', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('users', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('products', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('suppliers', function ($table) {
            $table->dropSoftDeletes();
        });
        Schema::table('departments', function ($table) {
            $table->dropSoftDeletes();
        });
    }
};
