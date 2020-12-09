<?php

namespace App\Exports;

use App\Models\User;
// use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

// use Maatwebsite\Excel\Concerns\RegistersEventListeners;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */

    // use RegistersEventListeners;

    public function collection()
    {
        return User::all('id', 'name', 'email');
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:C1'; // All headers
                $users = User::all()->count();
                $users +=1;
                $colRage = [0 => "A2:A$users", 1 => "B2:B$users", 2 => "C2:C$users"];
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setName('TH SarabunPSK');
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(16);

                $event->sheet->getDelegate()->getStyle($colRage[0])->getFont()->setName('TH SarabunPSK');
                $event->sheet->getDelegate()->getStyle($colRage[0])->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle($colRage[1])->getFont()->setName('TH SarabunPSK');
                $event->sheet->getDelegate()->getStyle($colRage[1])->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle($colRage[2])->getFont()->setName('TH SarabunPSK');
                $event->sheet->getDelegate()->getStyle($colRage[2])->getFont()->setSize(14);
            },
        ];
    }

    public function properties(): array
    {
        return [
            'creator' => 'Patrick Brouwers',
            'lastModifiedBy' => 'Patrick Brouwers',
            'title' => 'Invoices Export',
            'description' => 'Latest Invoices',
            'subject' => 'Invoices',
            'keywords' => 'invoices,export,spreadsheet',
            'category' => 'Invoices',
            'manager' => 'Patrick Brouwers',
            'company' => 'Maatwebsite',
        ];
    }

    public function title(): string
    {
        return 'Users';
    }

    public function headings(): array
    {
        return [
            'id',
            'Name',
            'Email',
        ];
    }
}
