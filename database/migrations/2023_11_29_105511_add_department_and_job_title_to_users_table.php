<?php

declare(strict_types=1);

use App\Models\User\Department;
use App\Models\User\JobTitle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDepartmentAndJobTitleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Department::class)->after('sex')->nullable()->constrained();
            $table->foreignIdFor(JobTitle::class)->after('department_id')->nullable()->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            Schema::dropIfExists('department_id');
            Schema::dropIfExists('job_title_id');
        });
    }
}
