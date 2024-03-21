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
        Schema::create('task_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('task_id')->comment('The id of task table');
            $table->integer('people_id')->comment('The id of commentor table');
            $table->text('comment')->nullable(true)->comment('The comment of the meeting member');
            $table->text('pdfs')->nullable(true)->comment('The pdf file attached with the comment');
            $table->integer('created_by')->nullable(true)->comment("Creater of the record");
            $table->integer('updated_by')->nullable(true)->comment("updater of the record");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_comments');
    }
};
