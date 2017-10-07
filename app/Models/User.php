<?php
/**
 * Users - A Users Model.
 *
 * @author Virgil-Adrian Teaca - virgil@giulianaeassociati.com
 * @version 3.0
 */

namespace App\Models;

use Nova\Auth\UserTrait;
use Nova\Auth\UserInterface;
use Nova\Auth\Reminders\RemindableTrait;
use Nova\Auth\Reminders\RemindableInterface;
use Nova\Database\ORM\Model as BaseModel;
use Nova\Foundation\Auth\Access\AuthorizableTrait;

use Shared\Database\ORM\FileField\FileFieldTrait;


class User extends BaseModel implements UserInterface, RemindableInterface
{
    use UserTrait, RemindableTrait, AuthorizableTrait, FileFieldTrait;

    //
    protected $table = 'users';

    protected $primaryKey = 'id';

    protected $fillable = array('role_id', 'username', 'password', 'realname', 'email', 'activated', 'image', 'activation_code', 'api_token');

    protected $hidden = array('password', 'activation_code', 'remember_token', 'api_token');

    public $files = array(
        'image' => array(
            'path'        => ROOTDIR .'assets/images/users/:unique_id-:file_name',
            'defaultPath' => ROOTDIR .'assets/images/users/no-image.png',
        ),
    );

    // For caching the permission slugs.
    protected $permissions;


    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($roles, $strict = false)
    {
        if (! array_key_exists('roles', $this->relations)) {
            $this->load('roles');
        }

        $roles = is_array($roles) ? $roles : array($roles);

        foreach ($this->roles->lists('slug') as $slug) {
            if (($slug === 'root') && ! $strict) {
                return true;
            }

            if (in_array($slug, $roles)) {
                return true;
            }
        }

        return false;
    }

    public function hasPermission($slug)
    {
        if (! isset($this->permissions)) {
            $collection = $this->newCollection();

            if (! array_key_exists('roles', $this->relations)) {
                $this->load('roles');
            }

            foreach ($this->roles as $role) {
                $role->load('permissions');

                $collection = $collection->merge($role->permissions);
            }

            $this->permissions = $collection->unique()->lists('slug');
        }

        return in_array($slug, $this->permissions);
    }
}
