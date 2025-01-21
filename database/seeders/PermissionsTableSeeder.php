<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('permissions')->delete();
        
        \DB::table('permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'View_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'ViewAny_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Create_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Update_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Delete_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Restore_User',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:09',
                'updated_at' => '2025-01-19 07:50:09',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'View_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            7 => 
            array (
                'id' => 8,
                'name' => 'ViewAny_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            8 => 
            array (
                'id' => 9,
                'name' => 'Create_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            9 => 
            array (
                'id' => 10,
                'name' => 'Update_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            10 => 
            array (
                'id' => 11,
                'name' => 'Delete_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Restore_Role',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:18',
                'updated_at' => '2025-01-19 07:50:18',
            ),
            12 => 
            array (
                'id' => 13,
                'name' => 'View_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            13 => 
            array (
                'id' => 14,
                'name' => 'ViewAny_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            14 => 
            array (
                'id' => 15,
                'name' => 'Create_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            15 => 
            array (
                'id' => 16,
                'name' => 'Update_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            16 => 
            array (
                'id' => 17,
                'name' => 'Delete_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            17 => 
            array (
                'id' => 18,
                'name' => 'Restore_Permission',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:26',
                'updated_at' => '2025-01-19 07:50:26',
            ),
            18 => 
            array (
                'id' => 19,
                'name' => 'View_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            19 => 
            array (
                'id' => 20,
                'name' => 'ViewAny_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            20 => 
            array (
                'id' => 21,
                'name' => 'Create_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            21 => 
            array (
                'id' => 22,
                'name' => 'Update_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            22 => 
            array (
                'id' => 23,
                'name' => 'Delete_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            23 => 
            array (
                'id' => 24,
                'name' => 'Restore_Province',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:37',
                'updated_at' => '2025-01-19 07:50:37',
            ),
            24 => 
            array (
                'id' => 25,
                'name' => 'View_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            25 => 
            array (
                'id' => 26,
                'name' => 'ViewAny_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            26 => 
            array (
                'id' => 27,
                'name' => 'Create_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            27 => 
            array (
                'id' => 28,
                'name' => 'Update_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            28 => 
            array (
                'id' => 29,
                'name' => 'Delete_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            29 => 
            array (
                'id' => 30,
                'name' => 'Restore_District',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:48',
                'updated_at' => '2025-01-19 07:50:48',
            ),
            30 => 
            array (
                'id' => 31,
                'name' => 'View_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            31 => 
            array (
                'id' => 32,
                'name' => 'ViewAny_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            32 => 
            array (
                'id' => 33,
                'name' => 'Create_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            33 => 
            array (
                'id' => 34,
                'name' => 'Update_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            34 => 
            array (
                'id' => 35,
                'name' => 'Delete_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            35 => 
            array (
                'id' => 36,
                'name' => 'Restore_City',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:50:55',
                'updated_at' => '2025-01-19 07:50:55',
            ),
            36 => 
            array (
                'id' => 37,
                'name' => 'View_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            37 => 
            array (
                'id' => 38,
                'name' => 'ViewAny_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            38 => 
            array (
                'id' => 39,
                'name' => 'Create_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            39 => 
            array (
                'id' => 40,
                'name' => 'Update_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            40 => 
            array (
                'id' => 41,
                'name' => 'Delete_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            41 => 
            array (
                'id' => 42,
                'name' => 'Restore_Outlet',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:03',
                'updated_at' => '2025-01-19 07:51:03',
            ),
            42 => 
            array (
                'id' => 43,
                'name' => 'View_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            43 => 
            array (
                'id' => 44,
                'name' => 'ViewAny_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            44 => 
            array (
                'id' => 45,
                'name' => 'Create_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            45 => 
            array (
                'id' => 46,
                'name' => 'Update_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            46 => 
            array (
                'id' => 47,
                'name' => 'Delete_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            47 => 
            array (
                'id' => 48,
                'name' => 'Restore_Employee',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:14',
                'updated_at' => '2025-01-19 07:51:14',
            ),
            48 => 
            array (
                'id' => 49,
                'name' => 'View_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            49 => 
            array (
                'id' => 50,
                'name' => 'ViewAny_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            50 => 
            array (
                'id' => 51,
                'name' => 'Create_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            51 => 
            array (
                'id' => 52,
                'name' => 'Update_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            52 => 
            array (
                'id' => 53,
                'name' => 'Delete_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            53 => 
            array (
                'id' => 54,
                'name' => 'Restore_Customer',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:26',
                'updated_at' => '2025-01-19 07:51:26',
            ),
            54 => 
            array (
                'id' => 55,
                'name' => 'View_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            55 => 
            array (
                'id' => 56,
                'name' => 'ViewAny_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            56 => 
            array (
                'id' => 57,
                'name' => 'Create_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            57 => 
            array (
                'id' => 58,
                'name' => 'Update_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            58 => 
            array (
                'id' => 59,
                'name' => 'Delete_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            59 => 
            array (
                'id' => 60,
                'name' => 'Restore_CustomerOrder',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:35',
                'updated_at' => '2025-01-19 07:51:35',
            ),
            60 => 
            array (
                'id' => 61,
                'name' => 'View_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            61 => 
            array (
                'id' => 62,
                'name' => 'ViewAny_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            62 => 
            array (
                'id' => 63,
                'name' => 'Create_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            63 => 
            array (
                'id' => 64,
                'name' => 'Update_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            64 => 
            array (
                'id' => 65,
                'name' => 'Delete_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            65 => 
            array (
                'id' => 66,
                'name' => 'Restore_CustomerOrderItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:51:52',
                'updated_at' => '2025-01-19 07:51:52',
            ),
            66 => 
            array (
                'id' => 67,
                'name' => 'View_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            67 => 
            array (
                'id' => 68,
                'name' => 'ViewAny_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            68 => 
            array (
                'id' => 69,
                'name' => 'Create_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            69 => 
            array (
                'id' => 70,
                'name' => 'Update_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            70 => 
            array (
                'id' => 71,
                'name' => 'Delete_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            71 => 
            array (
                'id' => 72,
                'name' => 'Restore_CustomerInvoice',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:02',
                'updated_at' => '2025-01-19 07:52:02',
            ),
            72 => 
            array (
                'id' => 73,
                'name' => 'View_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            73 => 
            array (
                'id' => 74,
                'name' => 'ViewAny_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            74 => 
            array (
                'id' => 75,
                'name' => 'Create_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            75 => 
            array (
                'id' => 76,
                'name' => 'Update_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            76 => 
            array (
                'id' => 77,
                'name' => 'Delete_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            77 => 
            array (
                'id' => 78,
                'name' => 'Restore_CustomerInvoiceItem',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:15',
                'updated_at' => '2025-01-19 07:52:15',
            ),
            78 => 
            array (
                'id' => 79,
                'name' => 'View_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            79 => 
            array (
                'id' => 80,
                'name' => 'ViewAny_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            80 => 
            array (
                'id' => 81,
                'name' => 'Create_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            81 => 
            array (
                'id' => 82,
                'name' => 'Update_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            82 => 
            array (
                'id' => 83,
                'name' => 'Delete_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            83 => 
            array (
                'id' => 84,
                'name' => 'Restore_Item',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:22',
                'updated_at' => '2025-01-19 07:52:22',
            ),
            84 => 
            array (
                'id' => 85,
                'name' => 'View_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            85 => 
            array (
                'id' => 86,
                'name' => 'ViewAny_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            86 => 
            array (
                'id' => 87,
                'name' => 'Create_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            87 => 
            array (
                'id' => 88,
                'name' => 'Update_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            88 => 
            array (
                'id' => 89,
                'name' => 'Delete_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            89 => 
            array (
                'id' => 90,
                'name' => 'Restore_Stock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:30',
                'updated_at' => '2025-01-19 07:52:30',
            ),
            90 => 
            array (
                'id' => 91,
                'name' => 'View_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            91 => 
            array (
                'id' => 92,
                'name' => 'ViewAny_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            92 => 
            array (
                'id' => 93,
                'name' => 'Create_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            93 => 
            array (
                'id' => 94,
                'name' => 'Update_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            94 => 
            array (
                'id' => 95,
                'name' => 'Delete_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            95 => 
            array (
                'id' => 96,
                'name' => 'Restore_ScheduleDelivery',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:49',
                'updated_at' => '2025-01-19 07:52:49',
            ),
            96 => 
            array (
                'id' => 97,
                'name' => 'View_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
            97 => 
            array (
                'id' => 98,
                'name' => 'ViewAny_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
            98 => 
            array (
                'id' => 99,
                'name' => 'Create_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
            99 => 
            array (
                'id' => 100,
                'name' => 'Update_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
            100 => 
            array (
                'id' => 101,
                'name' => 'Delete_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
            101 => 
            array (
                'id' => 102,
                'name' => 'Restore_ScheduleDeliveryStock',
                'guard_name' => 'web',
                'created_at' => '2025-01-19 07:52:59',
                'updated_at' => '2025-01-19 07:52:59',
            ),
        ));
        
        
    }
}