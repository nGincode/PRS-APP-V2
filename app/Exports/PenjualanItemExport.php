<?php

namespace App\Exports;

use App\Models\Bahan;
use App\Models\Orderitem;
use App\Models\POSBill;
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
use Maatwebsite\Excel\Concerns\ToArray;
use Throwable;

class PenjualanItemExport implements
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
                $event->sheet->getDelegate()->mergeCells('A1:G1');
                $event->sheet->getDelegate()->mergeCells('A2:G2');
                $event->sheet->getDelegate()->mergeCells('A4:B4');
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('1')->getFont()->setSize('12');
                $event->sheet->getDelegate()->getStyle('3')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('4')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('2')->getFont()->setBold(true);
                $event->sheet->getDelegate()->getStyle('2')->getFont()->setSize('11');
                $event->sheet->getDelegate()->getStyle('1')->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('2')->getAlignment()->setHorizontal('center');
            },
        ];
    }


    public function headings(): array
    {
        $store = Store::where('id', $this->store)->first();

        $result = [];

        $result[] = [
            strtoupper('LAPORAN PENJUALAN ' . $store->nama . ' Tanggal ' . date('d/m/Y', strtotime($this->tgl_awal)) . ' - ' . date('d/m/Y', strtotime($this->tgl_akhir)))
        ];
        $result[] = ['TIPE : ITEM'];
        $result[] = [''];
        $result[] = ['INFO'];
        $store = POSBillItem::select('tujuan')->distinct()->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->with('Store', 'PosBill')->get();
        $totalperoutletall = 0;
        foreach ($store as $va) {
            $vall = POSBillItem::where('tujuan', $va['tujuan'])->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->orderBy('tgl', 'ASC')->get();
            $totalperoutlet = 0;
            foreach ($vall as $vv) {
                $totalperoutlet += $vv['qty'] * $vv['harga'];
            }
            $result[] = ['-', ($va['tujuan'] ?? 'Tidak diketahui'),  '', '', '', '',  $totalperoutlet];
            $totalperoutletall += $totalperoutlet;
        }
        $result[] = ['', 'Total', '', '', '', '', $totalperoutletall];
        $result[] = [];
        $result[] = [
            '#',
            'Kode',
            'Nama Barang',
            'Harga Beli',
            'Qty',
            'UOM',
            'Harga',
            'Total'
        ];

        return $result;
    }


    public function array(): array
    {
        $pos = POSBillItem::where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->with('Store', 'PosBill')->orderBy('tgl', 'ASC')->get();
        $data = POSBillItem::select('nama')->distinct()->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->get();

        $result = [];
        $no = 1;
        $totalall = 0;
        foreach ($data as $key => $value) {
            $val = POSBillItem::where('nama', $value['nama'])->where('store_id', $this->store)->whereBetween('tgl', [$this->tgl_awal, $this->tgl_akhir])->orderBy('tgl', 'ASC')->get();

            $belanja = Belanja::where('bahan_id', $val[0]->bahan_id)->latest()->first();
            if ($belanja) {
                $hargabeli = $belanja['stock_harga'];
            } else {
                $hargabeli = '-';
            }


            $qty = 0;
            $satuan = $val[0]['satuan'];
            $harga = $val[0]['harga'];

            foreach ($val as $v) {
                $qty += $v['qty'];
            }

            $total = $harga * $qty;

            $totalall += $total;

            if ($bahan = Bahan::where('id', $val[0]->bahan_id)->first()) {
                $kode = $bahan['kode'];
            } else {
                $kode = '';
            }


            $pos = [
                $no++,
                $kode,
                $value['nama'],
                $hargabeli,
                $qty,
                $satuan,
                $harga,
                $total,
            ];
            $result[] = $pos;
        }
        $result[] = ['', 'Total', '',  '', '', '', $totalall];
        // dd($result);
        return $result;
    }


    public function failed(Throwable $exception): void
    {
    }
}
