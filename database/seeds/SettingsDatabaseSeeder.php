<?php

use App\Models\Settings;
use Illuminate\Database\Seeder;

class SettingsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::setMany([
            'default_locale' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currencies' => ['USD','LE','SAR'],
            'default_currency' => 'USD',
            'store_email' => 'admin@store.com',
            'search_engine' => 'mysql',
            'free_shipping_cost' => 0,  
            'local_shipping_cost' => 0,
            'flat_rate_cost' => 0,

            'translatable' => [
                'store_name' => 'DREAM',
                'free_shipping_label' => 'Free Shipping',
                'local_label' => 'Local Shipping',
                'outer_label' => 'Outer Shipping'
            ],
        ]);
    }
}
