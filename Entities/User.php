<?php

namespace Modules\Account\Entities;

use App\Models\Brand;
use App\Models\Election;
use App\Models\Honor;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\File;
use Laravel\Sanctum\HasApiTokens;
use Modules\Advertisement\Entities\Advertisement;
use Modules\Base\Entities\Photo;
use Modules\Project\Entities\Project;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;

    protected $guarded = [];

    protected static function newFactory()
    {
        return \Modules\Account\Database\factories\UserFactory::new();
    }

    public function getNameAttribute()
    {
        return $this->FirstName.' '. $this->LastName;
    }

    public function photo()
    {
        return $this->morphOne(Photo::class, 'pictures');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class,'id','brand_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function ($project){
            $project->photo()->get()->each(function ($photo){
                File::delete($photo->path);
                $photo->delete();
            });
        });
    }
}
