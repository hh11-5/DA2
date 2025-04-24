<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SanPham;
use App\Models\NhaSanXuat;

class SanPhamSeeder extends Seeder
{
    public function run()
    {
        // Tạo các nhà sản xuất mẫu
        $manufacturers = [
            [
                'tennhasx' => 'Rolex',
                'diachi' => 'Switzerland',
                'sdt' => '0123456789',
                'email' => 'contact@rolex.com'
            ],
            [
                'tennhasx' => 'Omega',
                'diachi' => 'Switzerland',
                'sdt' => '0123456788',
                'email' => 'contact@omega.com'
            ],
            [
                'tennhasx' => 'Cartier',
                'diachi' => 'France',
                'sdt' => '0123456787',
                'email' => 'contact@cartier.com'
            ],
            [
                'tennhasx' => 'Patek Philippe',
                'diachi' => 'Switzerland',
                'sdt' => '0123456786',
                'email' => 'contact@patekphilippe.com'
            ],
            [
                'tennhasx' => 'TAG Heuer',
                'diachi' => 'Switzerland',
                'sdt' => '0123456785',
                'email' => 'contact@tagheuer.com'
            ],
            [
                'tennhasx' => 'Seiko',
                'diachi' => 'Japan',
                'sdt' => '0123456784',
                'email' => 'contact@seiko.com'
            ],
            [
                'tennhasx' => 'Citizen',
                'diachi' => 'Japan',
                'sdt' => '0123456783',
                'email' => 'contact@citizen.com'
            ],
            [
                'tennhasx' => 'Longines',
                'diachi' => 'Switzerland',
                'sdt' => '0123456782',
                'email' => 'contact@longines.com'
            ],
            [
                'tennhasx' => 'Tissot',
                'diachi' => 'Switzerland',
                'sdt' => '0123456781',
                'email' => 'contact@tissot.com'
            ],
            [
                'tennhasx' => 'Casio',
                'diachi' => 'Japan',
                'sdt' => '0123456780',
                'email' => 'contact@casio.com'
            ]
        ];

        $nhasxs = [];
        foreach ($manufacturers as $manu) {
            $nhasxs[] = NhaSanXuat::create($manu);
        }

        // Tạo dữ liệu mẫu cho sản phẩm
        $products = [
            [
                'masp' => 'RL001',
                'tensp' => 'Rolex Submariner',
                'hinhsp' => 'images/products/watch1.jpg',
                'gia' => 150000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ 904L',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '41mm',
                'khangnuoc' => '300m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL002',
                'tensp' => 'Rolex Datejust',
                'hinhsp' => 'images/products/watch2.jpg',
                'gia' => 120000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ và vàng',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '36mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL003',
                'tensp' => 'Rolex Day-Date',
                'hinhsp' => 'images/products/watch3.jpg',
                'gia' => 200000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Vàng 18k',
                'clieuday' => 'Vàng 18k',
                'clieukinh' => '40mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL004',
                'tensp' => 'Rolex GMT-Master II',
                'hinhsp' => 'images/products/watch4.jpg',
                'gia' => 180000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '40mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL005',
                'tensp' => 'Rolex Lady-Datejust',
                'hinhsp' => 'images/products/watch5.jpg',
                'gia' => 110000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nữ',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '28mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL006',
                'tensp' => 'Rolex Yacht-Master',
                'hinhsp' => 'images/products/watch6.jpg',
                'gia' => 250000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Vàng Everose 18k',
                'clieuday' => 'Cao su',
                'clieukinh' => '40mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ],
            [
                'masp' => 'RL007',
                'tensp' => 'Rolex Air-King',
                'hinhsp' => 'images/products/watch7.jpg',
                'gia' => 140000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '40mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[0]->idnhasx
            ]
        ];

        // Thêm sản phẩm mới
        $additional_products = [
            // Omega
            [
                'masp' => 'OM001',
                'tensp' => 'Omega Seamaster',
                'hinhsp' => 'images/products/omega1.jpg',
                'gia' => 135000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '42mm',
                'khangnuoc' => '300m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[1]->idnhasx
            ],
            // Thêm các sản phẩm khác tương tự...
        ];

        // Merge với sản phẩm cũ và tạo
        $all_products = array_merge($products, $additional_products);
        foreach ($all_products as $product) {
            SanPham::create($product);
        }
    }
}
