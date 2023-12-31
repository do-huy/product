<?php

namespace Modules\SubCategory\database\seeders;

use Illuminate\Database\Seeder;
use Modules\SubCategory\app\Models\SubCategory;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sub_categories = [
            [
                'name' => 'Chăm sóc da mặt',
                'category_id' => '1',
                'slug' => 'cham_soc_da_mat'
            ],
            [
                'name' => ' Trang điểm ',
                'category_id' => '1',
                'slug' => 'trang_diem'
            ],
            [
                'name' => 'Chăm sóc cá nhân',
                'category_id' => '1',
                'slug' => 'cham_soc_ca_nhan'
            ],
            [
                'name' => 'Chăm sóc cơ thể',
                'category_id' => '1',
                'slug' => 'cham_soc_co_the'
            ],
            [
                'name' => 'Dược mỹ phẩm',
                'category_id' => '1',
                'slug' => 'duoc_my_pham'
            ],
            [
                'name' => 'Sản phẩm thiên nhiên & Khác',
                'category_id' => '1',
                'slug' => 'san_pham_thien_nhien_&_khac'
            ],
            [
                'name' => 'Chăm sóc tóc & da đầu',
                'category_id' => '1',
                'slug' => 'cham_soc_toc_&_da_dau'
            ],
            [
                'name' => 'Nước hoa',
                'category_id' => '1',
                'slug' => 'nuoc_hoa'
            ],
            [
                'name' => 'Dụng cụ làm đẹp',
                'category_id' => '1',
                'slug' => 'dung_cu_lam_dep'
            ],
            [
                'name' => 'Máy Massage & Thiết bị chăm sóc sức khỏe',
                'category_id' => '1',
                'slug' => 'may_massage_&_thiet_bi_cham_soc_suc_khoe'
            ],
            [
                'name' => 'Thực phẩm chức năng',
                'category_id' => '1',
                'slug' => 'thuc_pham_chuc_nang'
            ],
            [
                'name' => ' Hỗ trợ tình dục',
                'category_id' => '1',
                'slug' => 'ho_tro_tinh_duc'
            ],
            [
                'name' => ' Bộ sản phẩm làm đẹp',
                'category_id' => '1',
                'slug' => 'bo_san_pham_lam_dep'
            ],


            [
                'name' => 'Máy ảnh',
                'category_id' => '2',
                'slug' => 'may_anh'
            ],
            [
                'name' => 'Điện thoại',
                'category_id' => '2',
                'slug' => 'dien_thoai'
            ],
            [
                'name' => 'Máy vi tính',
                'category_id' => '2',
                'slug' => 'may_vi_tinh'
            ],
            [
                'name' => 'Điều hướng gps',
                'category_id' => '2',
                'slug' => 'dieu_huong_gps'
            ],
            [
                'name' => 'Tai nghe',
                'category_id' => '2',
                'slug' => 'tai_nghe'
            ],
            [
                'name' => 'Âm thanh gia đình',
                'category_id' => '2',
                'slug' => 'am_thanh_gia_dinh'
            ],
            [
                'name' => 'Tivi',
                'category_id' => '2',
                'slug' => 'tivi'
            ],
            [
                'name' => 'Máy chiếu video',
                'category_id' => '2',
                'slug' => 'may_chieu_video'
            ],
            [
                'name' => 'Máy may',
                'category_id' => '2',
                'slug' => 'may_may'
            ],




            [
                'name' => 'Áo nữ',
                'category_id' => '3',
                'slug' => 'ao_nu'
            ],
            [
                'name' => 'Đầm nữ',
                'category_id' => '3',
                'slug' => 'dam_nu'
            ],
            [
                'name' => 'Chân váy',
                'category_id' => '3',
                'slug' => 'chan_vay'
            ],
            [
                'name' => 'Quần nữ',
                'category_id' => '3',
                'slug' => 'quan_nu'
            ],
            [
                'name' => 'Áo khoác nữ',
                'category_id' => '3',
                'slug' => 'ao_khoac_nu'
            ],
            [
                'name' => 'Giày dép',
                'category_id' => '3',
                'slug' => 'giay_dep'
            ],
            [
                'name' => 'Trang sức',
                'category_id' => '3',
                'slug' => 'trang_suc'
            ],
            [
                'name' => 'Đồng hồ',
                'category_id' => '3',
                'slug' => 'dong_ho'
            ],
            [
                'name' => 'Túi xách',
                'category_id' => '3',
                'slug' => 'tui_xach'
            ],
            [
                'name' => 'Phụ kiện',
                'category_id' => '3',
                'slug' => 'phu_kien'
            ],
            [
                'name' => 'Đồ lót nữa',
                'category_id' => '3',
                'slug' => 'do_lot_nu'
            ],
            [
                'name' => 'Đồ ngủ & đồ mặc nhà nữ',
                'category_id' => '3',
                'slug' => 'do_ngu_&_do_mac_nha_nu'
            ],
            [
                'name' => 'Trang phục bơi nữ',
                'category_id' => '3',
                'slug' => 'trang_phuc_boi_nu'
            ],



            [
                'name' => 'Áo thun nam',
                'category_id' => '4',
                'slug' => 'ao_thun_nam'
            ],
            [
                'name' => 'Áo sơ mi nam',
                'category_id' => '4',
                'slug' => 'ao_so_mi_nam'
            ],
            [
                'name' => 'Áo vest & áo khoác nam',
                'category_id' => '4',
                'slug' => 'ao_vest_&_ao_khoac_nam'
            ],
            [
                'name' => 'Áo hoodie nam',
                'category_id' => '4',
                'slug' => 'ao_hoodie_nam'
            ],
            [
                'name' => 'Áo nỉ & áo len nam',
                'category_id' => '4',
                'slug' => 'ao_ni_&_ao_len_nam'
            ],
            [
                'name' => 'Quần nam',
                'category_id' => '4',
                'slug' => 'quan_nam'
            ],
            [
                'name' => 'Đồ ngủ & đồ mặc nhà nam',
                'category_id' => '4',
                'slug' => 'do_ngu_&_do_mac_nha_nam'
            ],
            [
                'name' => 'Đồ đôi & Đồ gia đình nam',
                'category_id' => '4',
                'slug' => 'do_doi_&_do_gia_dinh_nam'
            ],
            [
                'name' => 'Đồ lót nam',
                'category_id' => '4',
                'slug' => 'do_lot_nam'
            ],
            [
                'name' => 'Đồ bơi & Đồ đi biển nam',
                'category_id' => '4',
                'slug' => 'do_boi_&_do_di_bien_nam'
            ],


            [
                'name' => 'Giày cao gót',
                'category_id' => '5',
                'slug' => 'giay_cao_got'
            ],
            [
                'name' => 'Giày thể thao nữ',
                'category_id' => '5',
                'slug' => 'giay_the_thao_nu'
            ],
            [
                'name' => 'Giày sandals nữ',
                'category_id' => '5',
                'slug' => 'giay_sandals_nu'
            ],
            [
                'name' => 'Giày búp bê',
                'category_id' => '5',
                'slug' => 'giay_bup_be'
            ],
            [
                'name' => 'Giày đế xuồng nữ',
                'category_id' => '5',
                'slug' => 'giay_de_xuong_nu'
            ],
            [
                'name' => 'Giày boots nữ',
                'category_id' => '5',
                'slug' => 'giay_boots_nu'
            ],
            [
                'name' => 'Dép & Guốc nữ',
                'category_id' => '5',
                'slug' => 'dep_&_guoc_nu'
            ],
            [
                'name' => 'Giày lười nữ',
                'category_id' => '5',
                'slug' => 'giay_luoi_nu'
            ],
            [
                'name' => 'Phụ kiện giày',
                'category_id' => '5',
                'slug' => 'phu_kien_giay'
            ],



            [
                'name' => 'Giày thể thao nam',
                'category_id' => '6',
                'slug' => 'giay_the_thao_nam'
            ],
            [
                'name' => ' Giày lười nam',
                'category_id' => '6',
                'slug' => 'giay_luoi_nam'
            ],
            [
                'name' => ' Giày tây nam',
                'category_id' => '6',
                'slug' => 'giay_tay_nam'
            ],
            [
                'name' => 'Giày sandals nam',
                'category_id' => '6',
                'slug' => 'giay_sandals_nam'
            ],
            [
                'name' => 'Dép nam',
                'category_id' => '6',
                'slug' => 'dep_nam'
            ],
            [
                'name' => 'Giày boots nam',
                'category_id' => '6',
                'slug' => 'giay_boots_nam'
            ],
            [
                'name' => ' Phụ kiện giày nam',
                'category_id' => '6',
                'slug' => 'phu_kien_giay_nam'
            ],


            [
                'name' => 'Đồng hồ nam',
                'category_id' => '7',
                'slug' => 'dong_ho_nam'
            ],
            [
                'name' => 'Đồng hồ nữ',
                'category_id' => '7',
                'slug' => 'dong_ho_nu'
            ],
            [
                'name' => 'Đồng hồ trẻ em',
                'category_id' => '7',
                'slug' => 'dong_ho_tre_em'
            ],
            [
                'name' => 'Phụ kiện đồng hồ',
                'category_id' => '7',
                'slug' => 'phu_kien_dong_ho'
            ],
            [
                'name' => 'Trang sức',
                'category_id' => '7',
                'slug' => 'trang_suc'
            ],


            [
                'name' => 'Túi tote nữ',
                'category_id' => '8',
                'slug' => 'tui_tote_nu'
            ],
            [
                'name' => 'Túi đeo chéo & túi đeo vai nữ',
                'category_id' => '8',
                'slug' => 'tui_deo_cheo_&_tui_deo_vai_nu'
            ],
            [
                'name' => 'Túi xách tay nữ',
                'category_id' => '8',
                'slug' => 'tui_xach_tay_nu'
            ],
            [
                'name' => 'Ví nữ',
                'category_id' => '8',
                'slug' => 'Ví nữ'
            ],
            [
                'name' => 'Phụ kiện túi',
                'category_id' => '8',
                'slug' => 'phu_kien_tui'
            ],

            [
                'name' => 'Túi xách công sở nam',
                'category_id' => '9',
                'slug' => 'tui_xach_cong_so_nam'
            ],
            [
                'name' => 'Túi đeo chéo nam',
                'category_id' => '9',
                'slug' => 'tui_deo_cheo_nam'
            ],
            [
                'name' => 'Túi bao tử & túi đeo bụng',
                'category_id' => '9',
                'slug' => 'tui_bao_tu_&_tui_deo_bung'
            ],
            [
                'name' => 'Ví nam',
                'category_id' => '9',
                'slug' => 'vi_nam'
            ],


            [
                'name' => 'Mắt kính',
                'category_id' => '10',
                'slug' => 'mat_kinh'
            ],
            [
                'name' => 'Phụ kiện thời trang nữ',
                'category_id' => '10',
                'slug' => 'phu_kien_thoi_trang_nu'
            ],
            [
                'name' => 'Phụ kiện thời trang nam',
                'category_id' => '10',
                'slug' => 'phu_kien_thoi_trang_nam'
            ],


            [
                'name' => 'Đồ dùng nhà bếp',
                'category_id' => '11',
                'slug' => 'do_dung_nha_bep'
            ],
            [
                'name' => 'Thiết bị gia đình',
                'category_id' => '11',
                'slug' => 'thiet_bi_gia_dinh'
            ],

        ];

        foreach ($sub_categories as $sub_category) {
            $sub_category = SubCategory::create($sub_category);
        }
    }
}
