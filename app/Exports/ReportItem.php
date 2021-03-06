<?php

namespace App\Exports;

use App\Transaction;
use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use \Maatwebsite\Excel\Sheet;

class ReportItem implements FromView, ShouldAutoSize, WithEvents
{
    public $token;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }
    public function view(): View
    {
        if($this->token != 1){
            return null;
        }else{
            return view('exports.transaction', [
                'reports' => Transaction::with(['detail','user'])->get()
            ]);
        }

    }

  
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $cellRange = 'A1:F1'; // All headers
                // $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                $event->sheet->getDelegate()->setAutoFilter($cellRange);
                $event->sheet->getDelegate()->getStyle('A1:F2000')
                ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
                $event->sheet->getDelegate()->getStyle('B1:B2000')->getAlignment()->setWrapText(true);
            },
        ];
    }
}
