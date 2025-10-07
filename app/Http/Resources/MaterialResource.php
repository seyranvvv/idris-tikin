<?php

namespace App\Http\Resources;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaterialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
       return [
            'id' => $this->material_id,
            'code' => $this->material_code,
            'name' => $this->material_name,
            'category_name' => $this->category->m_cat_name ?? null,
            // 'category' => [
            //     'id' => $this->category->m_cat_id,
            //     'name' => $this->category->m_cat_name,
            //     'description' => $this->category->m_cat_desc
            // ],
           // 'unit' => $this->unit->name ?? null,
            //'prices' => PriceResource::collection($this->prices),
           // 'barcodes' => $this->barcodes->pluck('bar_barcode')
        ];
    }
}
