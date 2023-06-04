<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kategori extends Model
{
    use HasFactory, SoftDeletes;

    // protected $primaryKey = "id";
    protected $table = "kategori";
    protected $fillable = ["nm_kategori"];
    

    public function getCreatedAtAttribute( $value ) {

        return Carbon::parse($value)->timestamp;
    }
    public function getUpdatedAtAttribute( $value ) {

        return Carbon::parse($value)->timestamp;
    }
}
