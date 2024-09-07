<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Rohit Singh <rohit07rsr@gmail.com>
 * 07th Sept 2024
 */
class ToDo extends Model
{
    use HasFactory;
    protected $table = 'todos';
    protected $fillable = ['name', 'status'];
    protected $casts = [
        'status' => 'boolean',
    ];
}
