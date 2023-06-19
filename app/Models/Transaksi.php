<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = "transaksi";
    protected $fillable = ["user_id", "notes", "tanggal"];


    public function user() : BelongsTo{

    	return $this->belongsTo( User::class );
    }

}
