<?php


namespace App\Models\Traits;


use App\Models\ModelHasRole;
use App\Models\Role;

trait RoleTrait
{
    /**
     * Delete user role
     * @return void
     */
    public function deleteRole(): void
    {
        ModelHasRole::where('model_id', $this->getAttribute('id'))->delete();
    }

    /**
     * Add role to user
     * @param $role_name
     * @return void
     */
    public function addRole($role_name): void
    {
        $role_id = Role::where('name',$role_name)->first()->id;
        ModelHasRole::create([
            'role_id' => $role_id,
            'model_type' => 'App\Models\User',
            'model_id' => $this->getAttribute('id')
        ]);
    }

    /**
     * Check role for middleware
     * @param $role
     * @return bool
     */
    public function checkRole($role): bool
    {
        $roles = $this->myRoles;
        foreach ($roles as $role) {
            if ($role->name == 'admin') {
                return true;
            }
        }

        return false;
    }
}
