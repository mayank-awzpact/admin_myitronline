<?php

namespace App\Models\V2\API;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\V2\API\Category;


class Service extends Model
{
    use HasFactory;

    protected $table = 'tbl_service_v2';

    protected $fillable = [
        'uniqueId', 'productId', 'categoryIds', 'service_type', 'serviceName', 'serviceAlias', 'serviceHeading', 'serviceSynopsis', 'serviceDescription', 'status', 'servicePrice', 'govtFee', 'priceDiscount', 'gst', 'taxType', 'secTitle', 'secSTitle', 'secDescrption', 'serFaqTitle', 'serFaqContent', 'efiling_service_section', 'metaTitle', 'metaKeyword', 'background_img', 'Offer_date', 'metaDescription', 'robots', 'domain_source', 'tag', 'device', 'source', 'createdOn', 'createdBy', 'updatedOn', 'updatedBy', 'isTrashed', 'TrashedOn'
     
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'categoryIds', 'uniquid');
    }
    
}
