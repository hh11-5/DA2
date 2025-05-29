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
            [
                'masp' => 'TI001',
                'tensp' => 'Tissot PRX Powermatic 80',
                'hinhsp' => 'images/products/tissot1.jpg',
                'gia' => 25000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ 316L',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '40mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 2,
                'idnhasx' => $nhasxs[8]->idnhasx // Tissot
            ],
            [
                'masp' => 'CS001',
                'tensp' => 'Casio Edifice EQB-1200',
                'hinhsp' => 'images/products/casio1.jpg',
                'gia' => 15000000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '45mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[9]->idnhasx // Casio
            ],
            [
                'masp' => 'SK001',
                'tensp' => 'Seiko Presage SRPD37J1',
                'hinhsp' => 'images/products/seiko1.jpg',
                'gia' => 18000000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Da cá sấu',
                'clieukinh' => '41.7mm',
                'khangnuoc' => '50m',
                'tgbaohanh_nam' => 3,
                'idnhasx' => $nhasxs[5]->idnhasx // Seiko
            ],
            [
                'masp' => 'CT001',
                'tensp' => 'Citizen Eco-Drive AW1640-83E',
                'hinhsp' => 'images/products/citizen1.jpg',
                'gia' => 12000000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '42mm',
                'khangnuoc' => '100m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[6]->idnhasx // Citizen
            ],
            [
                'masp' => 'LG001',
                'tensp' => 'Longines Master Collection',
                'hinhsp' => 'images/products/longines1.jpg',
                'gia' => 45000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Da',
                'clieukinh' => '40mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 2,
                'idnhasx' => $nhasxs[7]->idnhasx // Longines
            ],
            [
                'masp' => 'TH001',
                'tensp' => 'TAG Heuer Formula 1',
                'hinhsp' => 'images/products/tagheuer1.jpg',
                'gia' => 35000000,
                'xuatxu' => 'Thụy Sĩ',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Cao su',
                'clieukinh' => '43mm',
                'khangnuoc' => '200m',
                'tgbaohanh_nam' => 2,
                'idnhasx' => $nhasxs[4]->idnhasx // TAG Heuer
            ],
            [
                'masp' => 'CS002',
                'tensp' => 'Casio G-Shock GA-2100',
                'hinhsp' => 'images/products/casio2.jpg',
                'gia' => 3200000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Nhựa composite',
                'clieuday' => 'Nhựa',
                'clieukinh' => '45.4mm',
                'khangnuoc' => '200m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[9]->idnhasx // Casio
            ],
            [
                'masp' => 'CS003',
                'tensp' => 'Casio MTP-1375L-1AV',
                'hinhsp' => 'images/products/casio3.jpg',
                'gia' => 1800000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Da',
                'clieukinh' => '41mm',
                'khangnuoc' => '50m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[9]->idnhasx // Casio
            ],
            [
                'masp' => 'SK002',
                'tensp' => 'Seiko 5 SNKL43K1',
                'hinhsp' => 'images/products/seiko2.jpg',
                'gia' => 4500000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '37mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[5]->idnhasx // Seiko
            ],
            [
                'masp' => 'CT002',
                'tensp' => 'Citizen BI5070-57H',
                'hinhsp' => 'images/products/citizen2.jpg',
                'gia' => 3600000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '40mm',
                'khangnuoc' => '50m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[6]->idnhasx // Citizen
            ],
            [
                'masp' => 'CS004',
                'tensp' => 'Casio Baby-G BGD-560',
                'hinhsp' => 'images/products/casio4.jpg',
                'gia' => 2800000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nữ',
                'clieuvo' => 'Nhựa',
                'clieuday' => 'Nhựa',
                'clieukinh' => '40mm',
                'khangnuoc' => '200m',
                'tgbaohanh_nam' => 5,
                'idnhasx' => $nhasxs[9]->idnhasx // Casio
            ],
            [
                'masp' => 'CT003',
                'tensp' => 'Citizen EQ0599-11A',
                'hinhsp' => 'images/products/citizen3.jpg',
                'gia' => 2900000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nữ',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Da',
                'clieukinh' => '36mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[6]->idnhasx // Citizen
            ],
            [
                'masp' => 'SK003',
                'tensp' => 'Seiko SWR052P1',
                'hinhsp' => 'images/products/seiko3.jpg',
                'gia' => 4200000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nữ',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '28.5mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[5]->idnhasx // Seiko
            ],
            [
                'masp' => 'CS005',
                'tensp' => 'Casio A168WG-9WDF',
                'hinhsp' => 'images/products/casio5.jpg',
                'gia' => 1500000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép mạ vàng',
                'clieuday' => 'Thép mạ vàng',
                'clieukinh' => '36.3mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[9]->idnhasx // Casio
            ],
            [
                'masp' => 'SK004',
                'tensp' => 'Seiko SUP880P1',
                'hinhsp' => 'images/products/seiko4.jpg',
                'gia' => 6500000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nữ',
                'clieuvo' => 'Thép không gỉ mạ vàng',
                'clieuday' => 'Thép không gỉ mạ vàng',
                'clieukinh' => '22mm',
                'khangnuoc' => '30m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[5]->idnhasx // Seiko
            ],
            [
                'masp' => 'CT004',
                'tensp' => 'Citizen NH8350-59L',
                'hinhsp' => 'images/products/citizen4.jpg',
                'gia' => 5800000,
                'xuatxu' => 'Nhật Bản',
                'kieu' => 'Đồng hồ nam',
                'clieuvo' => 'Thép không gỉ',
                'clieuday' => 'Thép không gỉ',
                'clieukinh' => '40mm',
                'khangnuoc' => '50m',
                'tgbaohanh_nam' => 1,
                'idnhasx' => $nhasxs[6]->idnhasx // Citizen
            ]
        ];

        // Merge với sản phẩm cũ và tạo
        $all_products = array_merge($products, $additional_products);
        foreach ($all_products as $product) {
            SanPham::create($product);
        }
    }
}
