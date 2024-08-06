<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, WithMapping, WithHeadings
{
    use Exportable;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->title,
            $row->price,
            $row->point_price,
            $row->sold,
            $row->image,
            $this->getVariationRow($row),
            $this->getAdditionalOptionsRow($row),
        ];
    }

    protected function getVariationRow($row)
    {
        $data = '';
        foreach ($row->variation_list as $variation) {
            $data .= $variation['name'] ?? '';
            if (is_array($variation['options'])) {
                $data = $data . ':' . implode(',', array_column($variation['options'], 'title'));
                $data .= "\n";
            }
        }

        return $data;
    }

    protected function getAdditionalOptionsRow($row)
    {
        $data = '';
        if (is_array($row->additional_options)) {
            $data = implode(',', array_column($row->additional_options, 'title'));
        }

        return $data;
    }

    public function view(): View
    {
        // TODO: Implement view() method.
        return view('excel.products', [
            'products' => $this->collection()
        ]);
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.

        return [
            '产品名称',
            '价格',
            '积分价格',
            '已售',
            '图片',
            '规格',
            '附加选项',
        ];
    }
}
