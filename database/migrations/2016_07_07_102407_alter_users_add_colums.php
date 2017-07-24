<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersAddColums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // alter fields
            $table->string('first_name', 50)->change();
            $table->string('last_name', 100)->change();
            // add new columns
            $table->string('mobile', 100)->after('last_name');
            $table->string('company_name')->nullable()->after('mobile');
            $table->string('position', 20)->nullable()->after('company_name');
            $table->string('career', 100)->nullable()->after('position');
            $table->string('other_email')->nullable()->after('career');
            $table->string('fb_url')->nullable()->after('other_email');
            $table->string('company_website')->nullable()->after('fb_url');
            $table->string('blog')->nullable()->after('company_website');
            $table->string('security_question1')->nullable()->after('blog');
            $table->string('security_question2')->nullable()->after('security_question1');
            $table->text('wanted')->after('security_question2');
            $table->timestamp('birthday')->after('wanted')->nullable();
            $table->tinyInteger('gender', false, true)->after('birthday')->default(0);
            $table->text('bio')->after('gender');
            $table->string('address')->nullable()->after('bio');
            $table->integer('photo', false, true)->nullable()->after('address');
            $table->string('street', 100)->nullable()->after('photo');
            $table->string('city', 100)->nullable()->after('street');
            $table->string('district', 100)->nullable()->after('city');
            $table->string('state', 100)->nullable()->after('district');
            $table->integer('country')->nullable()->after('state');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['votes', 'avatar', 'location']);
        });
    }
}
