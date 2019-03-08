<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsApproveToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('users'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                if (!Schema::hasColumn('users', 'is_approved'))
                {
                    $table->boolean('is_approved')->default('0')->after('remember_token');
                }
                if (!Schema::hasColumn('users', 'deleted_at'))
                {
                    $table->softDeletes();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('users'))
        {
            Schema::table('users', function (Blueprint $table)
            {
                if (Schema::hasColumn('users', 'is_approved'))
                {
                    $table->dropColumn('is_approved');
                }
                if (Schema::hasColumn('users', 'deleted_at'))
                {
                    $table->dropColumn('deleted_at');
                }
            });
        }
    }
}
