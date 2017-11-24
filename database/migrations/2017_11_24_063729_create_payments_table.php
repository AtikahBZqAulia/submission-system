<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pricing_types', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

        Schema::table('pricings', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('submission_event_id');
            $table->unsignedInteger('pricing_types_id');
            $table->unsignedInteger('price');

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');

        });

        Schema::create('payment_submissions', function(Blueprint $table) {
           $table->increments('id');
           $table->unsignedInteger('submission_id');
           $table->text('file')->nullable();
           $table->boolean('verified')->default(false);

            $table->timestamps();

            $table->unsignedInteger("created_by")->nullable();
            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });

        Schema::create('general_payments', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('submission_event_id');
            $table->unsignedInteger('pricing_id');
            $table->unsignedInteger('user_id');
            $table->text('file')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('verified')->default(false);

            $table->timestamps();

            $table->unsignedInteger("updated_by")->nullable();

            $table->foreign('updated_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
