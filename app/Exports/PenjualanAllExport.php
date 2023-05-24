<?php

namespace App\Exports;

use App\Models\Bahan;
use App\Models\Orderitem;
use App\Models\POSBillItem;
use App\Models\Store;
use App\Models\Belanja;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

use Throwable;

class PenjualanAllExport implements
    WithProperties,
    WithTitle,
    WithHeadings,
    ShouldAutoSize,
    WithEvents,
    FromArray
{

    use Exportable;

    protected $store;
    protected $tgl_awal;
    protected $tgl_akhir;

    public function __construct($store, $tgl_awal, $tgl_akhir)
    {
        $this->store = $store;
        $this->tgl_awal = $tgl_awal;
        $this->tgl_akhir = $tgl_akhir;
    }

    public function properties(): array
    {
        return [
            'creator'        => 'Fembi Nur Ilham',
            'lastModifiedBy' => 'Fembi Nur Ilham',
            'title'          => 'Penjualan',
            'description'    => 'Export Penjualan',
            'subject'        => 'Penjualan',
            'keywords'       => 'Penjualan,export,spreadsheet',
            'category'       => 'Penjualan',
            'manager'        => 'Fembi Nur Ilham',
            'company'        => 'Prima Rasa Selaras',
        ];
    }

    public function title(): string
    {
        return 'Penjualan';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:I1');
                $event->sheet->getDelegate()->mergeCells('A2:I2');
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize('12');
                $event->sheet->getDelegate()->getStyle('3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('1')->getAlignment()->setHorizontal('center');
            },
        ];
    }


    public function headings(): array
    {
        $store = Store::where('id', $this->store)->first();
        return [
            [
                strtoupper('LAPORAN PENJUALAN ' . $store->nama . ' Tanggal ' . date('d/m/Y', strtotime($this->tgl_awal)) . ' - ' . date('d/m/Y', strtotime($this->tgl_akhir)))
            ],
            [],
            [
                '#',
                'Tgl',
                'Dari',
                'Tujuan',
                'Kode',
                'Nama Barang',
                'Harga Beli',
                'Qty',
                'UOM',
                'Harga',
                'Total'
            ],
        ];
    }


    public function array(): array
    {

        $data = [];
        $pos = POSBillItem::where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->with('Store', 'Posbill')->orderBy('tgl', 'ASC')->orderBy('tgl', 'ASC')->get();
        $order = Orderitem::where('up', true)->where('logistik', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->with('Store')->get();

        $no = 1;
        $total = 0;
        // dd($pos);
        if ($pos) {
            foreach ($pos as $row) {
                $belanja = Belanja::where('bahan_id', $row->bahan_id)->latest()->first();

                if ($bahan = Bahan::where('id', $row->bahan_id)->first()) {
                    $kode = $bahan['kode'];
                } else {
                    $kode = '';
                }

                if ($belanja) {
                    $hargabeli = $belanja['stock_harga'];
                } else {
                    $hargabeli = '-';
                }
                $data[] = [
                    $no++,
                    date('Y/m/d', strtotime($row->tgl)),
                    'POS',
                    ($row['Posbill']->store ?? 'Pelanggan'),
                    $kode,
                    $row->nama,
                    $hargabeli,
                    $row->qty,
                    $row->satuan,
                    $row->harga,
                    $row->total,
                ];
                $total += $row->total;
            }
        }

        if ($order) {
            foreach ($order as $v) {

                if ($bahan = Bahan::where('id', $v->nama)->first()) {
                    $kode = $bahan['kode'];
                } else {
                    $kode = '';
                }

                $data[] = [
                    $no++,
                    date('Y/m/d', strtotime($v->tgl)),
                    'Order',
                    $v->store->nama,
                    $kode,
                    $v->nama,
                    $v->qty_deliv,
                    $v->satuan,
                    $v->harga,
                    $v->qty_deliv * $v->harga
                ];
                $total += $v->qty_deliv * $v->harga;
            }
        }
        if ($data) {
            $data[] = ['Total', '', '', '', '', '', '', '', '', $total];
        } else {
            $data[] = ['Tidak Ditemukan', '', '', '', '', '', '', '', ''];
        }
        // dd($data);
        return $data;
    }


    public function failed(Throwable $exception): void
    {
    }
}
