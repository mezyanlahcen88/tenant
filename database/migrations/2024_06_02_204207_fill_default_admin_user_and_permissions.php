<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Brackets\AdminAuth\Models\AdminUser;
use Illuminate\Database\Migrations\Migration;

/**
 * Class FillDefaultAdminUserAndPermissions
 */
class FillDefaultAdminUserAndPermissions extends Migration
{
    /**
     * @var Repository|mixed
     */
    protected $guardName;
    /**
     * @var mixed
     */
    protected $userClassName;
    /**
     * @var
     */
    protected $userTable;

    /**
     * @var array
     */
    protected $permissions;
    /**
     * @var array
     */
    protected $roles;
    /**
     * @var array
     */
    protected $users;

    /**
     * @var string
     */
    protected $password = '3B2A65sW4F';

    /**
     * FillDefaultAdminUserAndPermissions constructor.
     */
    public function __construct()
    {
        $this->guardName = config('admin-auth.defaults.guard');
        $providerName = config('auth.guards.' . $this->guardName . '.provider');
        $provider = config('auth.providers.' . $providerName);
        if ($provider['driver'] === 'eloquent') {
            $this->userClassName = $provider['model'];
        }
        $this->userTable = (new $this->userClassName)->getTable();

        $defaultPermissions = collect([
            // view admin as a whole
            'admin',

            // manage translations
            'admin.translation.index',
            'admin.translation.edit',
            'admin.translation.rescan',

            // manage users (access)
            'admin.admin-user.index',
            'admin.admin-user.create',
            'admin.admin-user.edit',
            'admin.admin-user.delete',

            // ability to upload
            'admin.upload',

            //ability to impersonal login
            'admin.admin-user.impersonal-login'
        ]);

        //Add new permissions
        $this->permissions = $defaultPermissions->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => $this->guardName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        })->toArray();

        //Add new roles
        $this->roles = [
            [
                'name' => 'admin',
                'guard_name' => $this->guardName,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'permissions' => $defaultPermissions->reject(function ($permission) {
                    return $permission === 'admin.admin-user.impersonal-login';
                }),
            ],
        ];

        //Add new users
      $this->users = [
            [
                'uuid' => Str::uuid(),
                'first_name' => 'Hassan',
                'last_name' => 'Mzn',
                'username' => 'admin',
                'email' => 'demo@demo.com',
                'password' => bcrypt('demo'),
                'isactive' => 1,
                'roles_name' => ['admin'],
                'country_id' => 149,
                'language_id' => 1,
                'state' => 'Kénitra',
                'city' => 'Kénitra',
                'phone' => '+212602086429',
                'picture' => 'user_df.jpg',
                'address' => 'maroc kenitra elwafaa',
                'codepostale' => '14000',
                'gender' => 'male',
                'language_id' => 1,
                'email_verified_at'=>now()
            ],
         ];
    }

    /**
     * Run the migrations.
     *
     * @throws Exception
     * @return void
     */
    public function up(): void
    {
        if ($this->userClassName === null) {
            throw new RuntimeException('Admin user model not defined');
        }
        DB::transaction(function () {
            foreach ($this->permissions as $permission) {
                $permissionItem = DB::table('permissions')->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem === null) {
                    DB::table('permissions')->insert($permission);
                }
            }

            foreach ($this->roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                $roleItem = DB::table('roles')->where([
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem === null) {
                    $roleId = DB::table('roles')->insertGetId($role);
                } else {
                    $roleId = $roleItem->id;
                }

                $permissionItems = DB::table('permissions')
                    ->whereIn('name', $permissions)
                    ->where(
                    'guard_name',
                    $role['guard_name']
                )->get();
                foreach ($permissionItems as $permissionItem) {
                    $roleHasPermissionData = [
                        'permission_id' => $permissionItem->id,
                        'role_id' => $roleId
                    ];
                    $roleHasPermissionItem = DB::table('role_has_permissions')->where($roleHasPermissionData)->first();
                    if ($roleHasPermissionItem === null) {
                        DB::table('role_has_permissions')->insert($roleHasPermissionData);
                    }
                }
            }

            foreach ($this->users as $user) {
                $roles = $user['roles'];
                unset($user['roles']);

                $permissions = $user['permissions'];
                unset($user['permissions']);

                $userItem = DB::table($this->userTable)->where([
                    'email' => $user['email'],
                ])->first();

                if ($userItem === null) {
                    $userId = DB::table($this->userTable)->insertGetId($user);

                    AdminUser::find($userId)->addMedia(storage_path() . '/images/avatar.png')
                        ->preservingOriginal()
                        ->toMediaCollection('avatar', 'media');

                    foreach ($roles as $role) {
                        $roleItem = DB::table('roles')->where([
                            'name' => $role['name'],
                            'guard_name' => $role['guard_name']
                        ])->first();

                        $modelHasRoleData = [
                            'role_id' => $roleItem->id,
                            'model_id' => $userId,
                            'model_type' => $this->userClassName
                        ];
                        $modelHasRoleItem = DB::table('model_has_roles')->where($modelHasRoleData)->first();
                        if ($modelHasRoleItem === null) {
                            DB::table('model_has_roles')->insert($modelHasRoleData);
                        }
                    }

                    foreach ($permissions as $permission) {
                        $permissionItem = DB::table('permissions')->where([
                            'name' => $permission['name'],
                            'guard_name' => $permission['guard_name']
                        ])->first();

                        $modelHasPermissionData = [
                            'permission_id' => $permissionItem->id,
                            'model_id' => $userId,
                            'model_type' => $this->userClassName
                        ];
                        $modelHasPermissionItem = DB::table('model_has_permissions')->where($modelHasPermissionData)->first();
                        if ($modelHasPermissionItem === null) {
                            DB::table('model_has_permissions')->insert($modelHasPermissionData);
                        }
                    }
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @throws Exception
     * @return void
     */
    public function down(): void
    {
        if ($this->userClassName === null) {
            throw new RuntimeException('Admin user model not defined');
        }
        DB::transaction(function () {
            foreach ($this->users as $user) {
                $userItem = DB::table($this->userTable)->where('email', $user['email'])->first();
                if ($userItem !== null) {
                    AdminUser::find($userItem->id)->media()->delete();
                    DB::table($this->userTable)->where('id', $userItem->id)->delete();
                    DB::table('model_has_permissions')->where([
                        'model_id' => $userItem->id,
                        'model_type' => $this->userClassName
                    ])->delete();
                    DB::table('model_has_roles')->where([
                        'model_id' => $userItem->id,
                        'model_type' => $this->userClassName
                    ])->delete();
                }
            }

            foreach ($this->roles as $role) {
                $roleItem = DB::table('roles')->where([
                    'name' => $role['name'],
                    'guard_name' => $role['guard_name']
                ])->first();
                if ($roleItem !== null) {
                    DB::table('roles')->where('id', $roleItem->id)->delete();
                    DB::table('model_has_roles')->where('role_id', $roleItem->id)->delete();
                }
            }

            foreach ($this->permissions as $permission) {
                $permissionItem = DB::table('permissions')->where([
                    'name' => $permission['name'],
                    'guard_name' => $permission['guard_name']
                ])->first();
                if ($permissionItem !== null) {
                    DB::table('permissions')->where('id', $permissionItem->id)->delete();
                    DB::table('model_has_permissions')->where('permission_id', $permissionItem->id)->delete();
                }
            }
        });
        app()['cache']->forget(config('permission.cache.key'));
    }
}
