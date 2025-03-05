<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AttributeValue;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'created_by', 'updated_by'];

    public function attributes()
    {
        return $this->morphMany(AttributeValue::class, 'entity');
    }

    public function attributeValues()
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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
