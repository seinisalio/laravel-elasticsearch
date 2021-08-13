<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Elasticquent\ElasticquentTrait;

class Article extends Model
{
    use HasFactory;
    use ElasticquentTrait;
    protected $fillable = ['title', 'montant', 'details', 'url_photo'];


    protected $mappingProperties = array(
    	"mappings" => [
    			"properties" => [
	      			"title" => [
			          "type" => "text",
			        ],
			        "montant" => [
			          "type" => "integer",
			        ],
			        "details" => [
			          "type" => "text",
			        ],
			        "url_photo" => [
			          "type" => "text",
			        ],
	      		]               
      	]
    );
    
    
}
