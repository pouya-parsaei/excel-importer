<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, withHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Product([
            'name' => $row['name'],
            'product_url' => $row['product_url'],
            'seo_title' => $row['seo_title'],
            'seo_description' => $row['seo_description'],
            'meta_keywords' => $row['meta_keywords'],
            'h1_1' => $row['h1_1'],
            'description' => $row['description'],
            'category' => $row['category'],
            'brand' => $row['brand'],
            'initial_price' => (int)$row['initial_price'],
            'price' => (int)$row['price'],
            'discount' => (int)$row['discount'],
            'single_price' => (int)$row['single_price'],
            'single_price_2' => (int)$row['single_price_2'],
            'image_url' => $row['image_url'],
        ]);
    }
}
