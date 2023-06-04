<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bahanbaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "bahanbaku";
    protected $fillable = ["nm_bahanbaku"];

}
