<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    // Permitir atribuição em massa
    protected $fillable = ['name', 'old_price', 'new_price'];
}