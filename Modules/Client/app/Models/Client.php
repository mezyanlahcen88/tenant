<?php

namespace Modules\Client\app\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Client\Database\factories\ClientFactory;
use Illuminate\Support\Str;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    public $fillable = ['name', 'email', 'picture', 'pdf'];
    private $files = ['picture', 'pdf'];
    public function getFiles()
    {
        return $this->files;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
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
            'name' => 'name',
        ];
    }

    /**
     *getters pour recuperer les attribute de type file pour l'utiliser dans le crud
     *
     */

    public function getRowsTableTrashed()
    {
        return [
            'name' => 'name',
        ];
    }
}
