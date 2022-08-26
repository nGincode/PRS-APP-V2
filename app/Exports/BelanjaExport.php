<?php

namespace App\Exports;

use App\Models\Belanja;
use App\Models\Orderitem;
use App\Models\POSBillItem;
use App\Models\Store;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithProperties;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;

use Throwable;

class BelanjaExport implements
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
            'title'          => 'Belanja',
            'description'    => 'Export Belanja',
            'subject'        => 'Belanja',
            'keywords'       => 'Belanja,export,spreadsheet',
            'category'       => 'Belanja',
            'manager'        => 'Fembi Nur Ilham',
            'company'        => 'Prima Rasa Selaras',
        ];
    }

    public function title(): string
    {
        return 'Belanja';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->mergeCells('A1:H1');
                $event->sheet->getDelegate()->mergeCells('A2:H2');
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
                strtoupper('LAPORAN Belanja ' . $store->nama . ' Tanggal ' . date('d/m/Y', strtotime("-1 day", strtotime($this->tgl_awal))) . ' - ' . date('d/m/Y', strtotime($this->tgl_akhir)))
            ],
            [],
            [
                '#',
                'Tgl',
                'Kategori',
                'Nama Barang',
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
        $belanja = Belanja::where('up', true)->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->with('Store')->orderBy('kategori', 'DESC')->get();
        $kategori = Belanja::select('kategori')->distinct()->where('up', true)->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])
            ->get();

        if ($belanja) {
            foreach ($kategori as $v) {
                $total = 0;
                $no = 1;
                $array = [];
                foreach ($belanja as $row) {
                    if ($v['kategori'] == $row['kategori']) {
                        if ($row->bahan_id) {
                            $harga = $row->stock_harga;
                            $qty = $row->stock;
                            $uom = $row->stock_uom;
                        } else {
                            $harga = $row->harga;
                            $qty = $row->qty;
                            $uom = $row->uom;
                        }

                        $array[] = [
                            $no++,
                            date('Y/m/d', strtotime($row->tgl)),
                            $row->kategori,
                            $row->nama,
                            $qty,
                            $uom,
                            $harga,
                            $harga * $qty
                        ];
                        $total += $harga * $qty;
                    }
                }
                $array[] = ['Total', '', '', '', '', '', '', $total];
                $array[] = [''];
                $data[] = $array;
            }
        } else {
            $data[] = ['Tidak Ditemukan', '', '', '', '', '', '', ''];
        }

        // dd($kategori);
        return $data;
    }


    public function failed(Throwable $exception): void
    {
    }
}
