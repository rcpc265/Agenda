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
        'office_name'
    ];

    public static $statusTranslations = [
        'pending' => 'Pendiente',
        'confirmed' => 'Confirmado',
        'canceled' => 'Cancelado'
    ];

    public static $statusColors = [
        'pending' => 'text-yellow',
        'confirmed' => 'text-success',
        'canceled' => 'text-danger'
    ];

    private function capitalizeValue($value)
    {
        return ucwords(strtolower($value));
    }

    public function getStatusDisplayAttribute(): string
    {
        return self::$statusTranslations[$this->status];
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
