<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Itstructure\LaRbac\Helpers\Helper;
use Itstructure\LaRbac\Exceptions\InvalidConfigException;

/**
 * Class CreateUserRoleTable
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class CreateUserRoleTable extends Migration
{
    /**
     * @var string
     */
    private $userModelClass;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userModelClass = config('rbac.userModelClass');

        Helper::checkUserModel($this->userModelClass);
    }

    /**
     * Run the migrations.
     * @throws Exception
     * @throws InvalidConfigException
     */
    public function up()
    {
        /* @var Illuminate\Foundation\Auth\User $userModel */
        $userModel = new $this->userModelClass();
        $userModel->getKeyType();

        $userModelKeyType = $userModel->getKeyType();

        if (!in_array($userModelKeyType, ['int', 'integer'])) {
            throw new InvalidConfigException('User Model keyType must be type of int.');
        }

        $userModelTable = $userModel->getTable();

        $userModelKeyName = $userModel->getAuthIdentifierName();

        $usersTablePrimaryType = Schema::getConnection()->getDoctrineColumn($userModelTable, $userModelKeyName)->getType()->getName();

        if (!in_array($usersTablePrimaryType, ['bigint', 'integer'])) {
            throw new \Exception('Primary key '.$userModelKeyName.' in '.$userModelTable.' must be type of bigint or integer');
        }

        Schema::create('user_role', function (Blueprint $table) use ($userModelKeyName, $userModelTable, $usersTablePrimaryType) {
            switch ($usersTablePrimaryType) {
                case 'bigint':
                    $table->unsignedBigInteger('user_id');
                    break;
                case 'integer':
                    $table->unsignedInteger('user_id');
                    break;
            }
            $table->unsignedInteger('role_id');
            $table->timestamps();
            $table->unique(['user_id','role_id']);
            $table->foreign('user_id')->references($userModelKeyName)->on($userModelTable)->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
    }
}
