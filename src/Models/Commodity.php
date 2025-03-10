<?php
namespace Sajed13\Commodity\Models;

use Illuminate\Database\Eloquent\Model;

class Commodity extends Model
{
    protected $fillable = [
        'name',
        'price',
        'day',
        'present',
        'weekly',
        'monthly',
        'date',
    ];
}
