<?php
namespace App\Exports;

use App\Models\Reservasi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReservasiExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $ownerId;

    public function __construct($ownerId = null)
    {
        $this->ownerId = $ownerId;
    }

    public function collection()
    {
        $query = Reservasi::with(['user', 'studio', 'pembayaran'])->latest();

        if ($this->ownerId) {
            $query->whereHas('studio', fn($q) => $q->where('id_owner', $this->ownerId));
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Customer',
            'Email',
            'Studio',
            'Tanggal',
            'Jam Mulai',
            'Jam Selesai',
            'Durasi (Jam)',
            'Total Harga',
            'Status Reservasi',
            'Status Pembayaran',
            'Metode Bayar',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->user->nama ?? '-',
            $row->user->email ?? '-',
            $row->studio->nama_studio ?? '-',
            $row->tanggal->format('d/m/Y'),
            $row->jam_mulai,
            $row->jam_selesai,
            $row->durasi_jam,
            'Rp ' . number_format($row->total_harga, 0, ',', '.'),
            $row->status_label,
            $row->pembayaran?->status_label ?? 'Belum Bayar',
            $row->pembayaran?->metode_label ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '7C3AED']],
            ],
        ];
    }
}