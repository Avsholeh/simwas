<?php

namespace App\Enums;

enum SptStatus: string
{
    case Draft = 'Draft';
    case Disetujui = 'Disetujui';
    case Ditolak = 'Ditolak';
    case Dibatalkan = 'Dibatalkan';
    case SedangBerjalan = 'Sedang Berjalan';
    case Selesai = 'Selesai';
}
