<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliverymans';
    protected $primaryKey = 'id';

    protected $fillable = [
        "name",
        "cpf"
    ];

    protected $guarded  = [
        'id', 'created_at', 'updated_at' 
    ];
}
