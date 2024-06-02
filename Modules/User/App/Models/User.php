<?php

namespace Modules\User\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\User\Database\factories\UserFactory;
use Illuminate\Support\Str;

class User extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['uuid', 'name', 'email', 'password','avatar', 'last_login_at', 'last_login_ip', 'profile_photo_path'];
    private $files = ['avatar'];
    public function getFiles()
    {
        return $this->files;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }

    //  put the relation of this Model Here

    /**
     *getters pour recuperer les attribute de type file pour l'utiliser dans le crud
     *
     */

    public function getRowsTable()
    {
        return [
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'username' => 'username',
            'email' => 'email',
        ];
    }

    /**
     *getters pour recuperer les attribute de type file pour l'utiliser dans le crud
     *
     */

    public function getRowsTableTrashed()
    {
        return [
            'first_name' => 'first_name',
            'last_name' => 'last_name',
            'username' => 'username',
            'email' => 'email',
        ];
    }
}
