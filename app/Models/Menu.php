<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Kategori;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "menu";
    protected $fillable = ["kategori_id", "nm_menu", "price", "description"];


    public function kategori() : BelongsTo{

    	return $this->belongsTo(Kategori::class);
    }
}
