<?php

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Users\Models\User;
use Modules\Users\Models\UserPermission;

class WebmasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (!empty(env('WEBMASTER_EMAIL'))) {
            DB::transaction(function () {
                $role = Role::firstOrNew(['name' => 'webmaster']);
                $role->type = 1;
                $role->save();

                $user = User::firstOrNew(['email' => trim(env('WEBMASTER_EMAIL'))]);
                $user->name = trim(env('WEBMASTER_NAME'));
                $user->avatar = trim(env('WEBMASTER_AVATAR')) ?? null;
                $user->password = trim(env('WEBMASTER_PASSWORD'));
                $user->role_id = $role->id;
                $user->save();

                UserPermission::firstOrCreate([
                    'user_id' => $user->id,
                    'create' => true,
                    'read' => true,
                    'update' => true,
                    'delete' => true
                ]);
            });
        }
    }
}
