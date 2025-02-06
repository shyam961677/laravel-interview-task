<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportUser implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */    
    public function collection()
    {
        return User::query()
            ->select(
                'name',
                'email',
                'image',
                'mobile',
                'date',
                'role',
                'created_at'
            )->get()->map(function ($user) {
                $image = $user->image ? asset($user->image) : 'N/A';

                return [
                    $user->name ?? 'N/A',
                    $user->email ?? 'N/A',
                    $image !== 'N/A' 
                        ? '=HYPERLINK("' . $image . '", "Image")' 
                        : 'N/A',
                    $user->mobile ?? 'N/A',
                    $user->date ?? 'N/A',
                    $user->role ?? 'N/A',
                    $user->created_at ? $user->created_at->format('d-M-Y') : 'N/A',
                ];
            });
    }

    /**
    * @return array
    */
    public function headings(): array
    {
        $headings = [
            'Name',
            'Email',
            'Image',
            'Mobile',
            'Date',
            'Role',
            'Created Date',
        ];

        return array_map(function ($heading) {
            return ucwords(str_replace('_', ' ', $heading));
        }, $headings);
    }
}
