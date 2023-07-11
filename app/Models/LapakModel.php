<?php

namespace App\Models;

use CodeIgniter\Model;

class LapakModel extends Model
{
    protected $table      = 'lapak';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'img_lapak', 
        'title_lapak',
        'price',
        'short_description',
        'description_lapak'
    ];
}
