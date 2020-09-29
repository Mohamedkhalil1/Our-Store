<?php 

namespace App\Http\Enumerations;
use Spatie\Enum\Enum;

final class CategoryType extends Enum{

    const category = 'parent';
    const subCategory = 'child';
}