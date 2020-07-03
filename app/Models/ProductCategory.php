<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class ProductCategory extends LocalizedModel
{
    use HasJsonRelationships;

    public const BABY = 1;
    public const BABY_BOY = 8;
    public const BABY_GIRL = 9;
    public const TODDLER = 2;
    public const TODDLER_BOY = 10;
    public const TODDLER_GIRL = 11;
    public const TEENAGER = 3;
    public const TEENAGER_BOY = 12;
    public const TEENAGER_GIRL = 13;
    public const BABY_CARE = 5;
    public const BABY_CARE_0 = 14;
    public const BABY_CARE_3 = 15;
    public const BABY_FOOD = 6;
    public const BABY_FOOD_0 = 16;
    public const BABY_FOOD_3 = 17;
    public const ACCESSORIES = 7;
    public const ACCESSORIES_0 = 18;
    public const ACCESSORIES_3 = 19;
    public const TOYS = 20;

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description','image','alias','status','size_type'
    ];

    protected $casts = [
        'parent_ids' => 'json',
        'child_ids' => 'json',
    ];

    public function children()
    {
        return $this->hasMany(self::class,'parent_id');
    }

    public function models()
    {
        return $this->hasManyJson(ProductModel::class, 'category_ids');
    }


    // public function createTree($data)
    // {
    //     $parents = [];

    //     foreach ($data as $key => $item):
    //         $parents[$item['parent_id']][$item['id']] = $item;
    //     endforeach;

    //     $treeElem = $parents[null];
    //     $this->generateElemTree($treeElem, $parents);

    //     return $treeElem;
    // }

    // private function generateElemTree(&$treeElem, $parents)
    // {
    //     foreach ($treeElem as $key => $item):
    //         if (!isset($item['children'])):
    //             $treeElem[$key]['children'] = [];
    //         endif;

    //         if (array_key_exists($key, $parents)):
    //             $treeElem[$key]['children'] = $parents[$key];
    //             $this->generateElemTree($treeElem[$key]['children'], $parents);
    //         endif;
    //     endforeach;
    // }
}
