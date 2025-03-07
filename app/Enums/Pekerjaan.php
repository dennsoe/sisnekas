<?php

namespace App\Enums;

enum Pekerjaan: string
{
    case TIDAK_BEKERJA = 'Tidak Bekerja';
    case NELAYAN = 'Nelayan';
    case PETANI = 'Petani';
    case PETERNAK = 'Peternak';
    case PNS_TNI_POLRI = 'PNS/TNI/Polri';
    case KARYAWAN_SWASTA = 'Karyawan Swasta';
    case PEDAGANG_KECIL = 'Pedagang Kecil';
    case PEDAGANG_BESAR = 'Pedagang Besar';
    case WIRASWASTA = 'Wiraswasta';
    case WIRAUSAHA = 'Wirausaha';
    case BURUH = 'Buruh';
    case PENSIUNAN = 'Pensiunan';
    case TKI = 'Tenaga Kerja Indonesia';
    case TIDAK_DAPAT_DITERAPKAN = 'Tidak dapat diterapkan';
    case SUDAH_MENINGGAL = 'Sudah Meninggal';
    case LAINNYA = 'Lainnya';

    public static function toArray(): array
    {
        return array_combine(
            array_column(self::cases(), 'value'),
            array_column(self::cases(), 'value')
        );
    }
}