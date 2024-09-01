<?php

namespace App\Enums;

enum SptStatus: string
{
    case Draft = 'Draft';
    case VerifikasiIrban = 'Verifikasi Irban';
    case VerifikasiInspektur = 'Verifikasi Inspektur';
    case Disetujui = 'Disetujui';
    case Ditolak = 'Ditolak';
    case Dibatalkan = 'Dibatalkan';
    case SedangBerjalan = 'Sedang Berjalan';
    case Selesai = 'Selesai';
    case Diperpanjang = 'Diperpanjang';
    case Diperiksa = 'Diperiksa';
    case Dikembalikan = 'Dikembalikan';
    case Diketahui = 'Diketahui';
}
