<?php

namespace App\Imports;

use App\Models\Bahan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\ToModel;


use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Throwable;

class BahanImport implements
    ToModel,
    // ToCollection,
    // SkipsOnError,
    WithHeadingRow
{
    use Importable;

    public function headingRow(): int
    {
        return 11;
    }

    public function model(array $row)
    {
        return new Bahan([
            'id' => $row['id'],
            'nama' => $row['nama'],
            'kode' => $row['kode'],
            'kategori' => $row['kategori'],
            'satuan_pembelian' => $row['satuan_pembelian'],
            'harga' => $row['harga'],
            'satuan_pemakaian' => $row['satuan_pemakaian'],
            'konversi_pemakaian' => $row['pembelian_ke_pemakaian'],
            'satuan_pengeluaran' => $row['satuan_pengeluaran'],
            'konversi_pengeluaran' => $row['pembelian_ke_pengeluaran']
        ]);
    }
}
