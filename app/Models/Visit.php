<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'name',
        'start_date',
        'end_date',
        'code',
        'status',
        'office_name',
        'visitor_id',
        'user_id'
    ];

    public function status()
    {
        return self::$statusColors;
    }

    public static $statusColors = [
        'Pendiente' => 'primary',
        'Confirmado' => 'success',
        'Cancelado' => 'danger'
    ];

    public static $statuses = [
        'Pendiente',
        'Confirmado',
        'Cancelado'
    ];

    private function capitalizeValue($value)
    {
        return ucwords(strtolower($value));
    }

    public function getStatusColorAttribute(): string
    {
        return self::$statusColors[$this->status];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $this->capitalizeValue($value);
    }

    public function setSubjectAttribute($value)
    {
        $this->attributes['subject'] = $this->capitalizeValue($value);
    }

    public function setOfficeNameAttribute($value)
    {
        $this->attributes['office_name'] = $this->capitalizeValue($value);
    }
}
