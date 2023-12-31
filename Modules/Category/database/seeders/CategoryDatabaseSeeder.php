<?php

namespace Modules\Category\database\seeders;

use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Làm đẹp & sức khỏe',
            'slug' => 'lam-dep-va-suc-khoe',
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Điện tử',
            'slug' => 'dien-tu',
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Thời trang nữ',
            'slug' => 'thoi-trang-nu'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Thời trang nam',
            'slug' => 'thoi-trang-nam'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Giày dép nữ',
            'slug' => 'giay-dep-nu'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Giày dép nam',
            'slug' => 'giay-dep-nam'
        ]);

        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Đồng hồ & trang sức',
            'slug' => 'dong-ho-va-thoi-trang'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Túi thời trang nữ',
            'slug' => 'tui-thoi-trang-nu'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Túi thời trang nam',
            'slug' => 'tui-thoi-trang-nam'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Phụ kiện thời trang',
            'slug' => 'phu-kien-thoi-trang'
        ]);
        \Modules\Category\app\Models\Category::factory()->create([
            'name' => 'Điện gia dụng',
            'slug' => 'dien-gia-dung',
        ]);
    }
}
