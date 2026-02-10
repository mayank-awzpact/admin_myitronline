<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'tbl_category_v2';

    protected $fillable = [
        'uniquid', 'priority', 'category_name', 'heading', 'alias', 'synopsis', 'status', 'meta_title', 'meta_description', 'robots', 'createdBy', 'createdOn', 'domain_source', 'updateOn', 'isTrashed', 'trashedOn' 
     
    ];
}
