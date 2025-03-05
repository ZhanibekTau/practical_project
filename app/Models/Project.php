<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status'];


    public function attributes()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }
}
