<?php

namespace App\Exports;

use App\Models\Bahan;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

use Throwable;

class BahanExport implements
    WithProperties,
    WithTitle,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    FromArray
{

    use Exportable;

    public function properties(): array
    {
        return [
            'creator'        => 'Fembi Nur Ilham',
            'lastModifiedBy' => 'Fembi Nur Ilham',
            'title'          => 'Master Bahan',
            'description'    => 'Export Master Bahan',
            'subject'        => 'Master Bahan',
            'keywords'       => 'Master Bahan,export,spreadsheet',
            'category'       => 'Master Bahan',
            'manager'        => 'Fembi Nur Ilham',
            'company'        => 'Prima Rasa Selaras',
        ];
    }

    public function title(): string
    {
        return 'Master Bahan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:J1');
                $event->sheet->getDelegate()->mergeCells('A2:J2');
                $event->sheet->getDelegate()->mergeCells('A3:J3');
                $event->sheet->getDelegate()->mergeCells('A4:J4');
                $event->sheet->getDelegate()->mergeCells('A5:J5');
                $event->sheet->getDelegate()->mergeCells('A6:J6');
                $event->sheet->getDelegate()->mergeCells('A7:J7');
                $event->sheet->getDelegate()->mergeCells('A8:J8');
                $event->sheet->getDelegate()->mergeCells('A9:J9');
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize('15');
                $event->sheet->getDelegate()->getStyle('3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('11')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('1')->getAlignment()->setHorizontal('center');
            },
        ];
    }


    public function headings(): array
    {
        return [
            [
                strtoupper('Master Bahan')
            ],
            [],
            ['Ket Kode Kategori :'],
            ['1 = Bahan Baku Segar'],
            ['2 = Bahan Baku Beku'],
            ['3 = Bahan Baku Dalam Kemasan'],
            ['4 = Bahan Baku Beku Dingin'],
            ['11 = Bahan Supplay'],
            ['21 = Bahan Oprasional'],
            [],
            [
                'ID',
                'Kode',
                'Nama',
                'Kategori',
                'Satuan Pembelian',
                'Harga',
                'Satuan Pemakaian',
                'Pembelian ke Pemakaian',
                'Satuan Pengeluaran',
                'Pembelian Ke Pengeluaran',
            ],
        ];
    }


    public function array(): array
    {
        $data = [];
        $array = Bahan::orderBy('kode', 'ASC')->get();

        if ($array) {
            foreach ($array as $key => $row) {
                $data[] = [
                    $row->id,
                    $row->kode,
                    $row->nama,
                    $row->kategori,
                    $row->satuan_pembelian,
                    $row->harga,
                    $row->satuan_pemakaian,
                    $row->konversi_pemakaian,
                    $row->satuan_pengeluaran,
                    $row->konversi_pengeluaran
                ];
            }
        }
        if (!$data) {
            $data[] = ['Tidak Ditemukan', '', '', '', '', '', '', ''];
        }
        // dd($data);
        return $data;
    }


    public function failed(Throwable $exception): void
    {
    }
}
