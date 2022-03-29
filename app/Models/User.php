<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $guarded = [ "id" ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function group() {
        return $this->hasMany(UserGroup::class);
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", 'id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function manager()
    {
        return $this->belongsTo("App\Models\User", 'manager_id');
    }

    public function degelated()
    {
        return $this->belongsTo("App\Models\User", 'delegated_id');
    }

    public function managees()
    {
        return $this->hasMany(User::class, 'manager_id');
    }

    public function jobGrade()
    {
        return $this->belongsTo(JobGrade::class);
    }

    public function jobName()
    {
        return $this->belongsTo(JobName::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
