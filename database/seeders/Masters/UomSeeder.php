<?php

namespace Database\Seeders\Masters;

use App\DataTransferObjects\Masters\UomData;
use App\Facades\Elasticsearch;
use App\Models\Masters\Uom;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $uoms = [
            ['name' => 'Pcs', 'keterangan' => 'Piece'],
            ['name' => 'SET', 'keterangan' => 'Set'],
            ['name' => 'Paket', 'keterangan' => 'Paket'],
            ['name' => 'DRM', 'keterangan' => 'Drum'],
            ['name' => 'PL', 'keterangan' => 'Pail'],
            ['name' => 'Unit', 'keterangan' => null],
            ['name' => 'Liter', 'keterangan' => null],
            ['name' => 'Lumpsum', 'keterangan' => null],
            ['name' => 'Orang', 'keterangan' => null],
            ['name' => 'Lembar', 'keterangan' => null],
            ['name' => 'CM', 'keterangan' => null],
            ['name' => 'METER', 'keterangan' => null],
            ['name' => 'KG', 'keterangan' => null],
            ['name' => 'TON', 'keterangan' => null],
            ['name' => 'Bulan', 'keterangan' => null],
            ['name' => 'HOUR', 'keterangan' => null],
            ['name' => 'Hari', 'keterangan' => null],
            ['name' => 'ROL', 'keterangan' => null],
            ['name' => 'Rim', 'keterangan' => null],
            ['name' => 'BOX', 'keterangan' => null],
            ['name' => 'PC', 'keterangan' => null],
            ['name' => 'PAC', 'keterangan' => null],
            ['name' => 'BAG', 'keterangan' => null],
            ['name' => 'BOT', 'keterangan' => null],
            ['name' => 'CAN', 'keterangan' => null],
            ['name' => 'DAY', 'keterangan' => null],
            ['name' => 'DRM', 'keterangan' => null],
            ['name' => 'DZN', 'keterangan' => null],
            ['name' => 'EA', 'keterangan' => null],
            ['name' => 'FT', 'keterangan' => null],
            ['name' => 'G', 'keterangan' => null],
            ['name' => 'GAL', 'keterangan' => null],
            ['name' => 'H', 'keterangan' => null],
            ['name' => 'IN', 'keterangan' => null],
            ['name' => 'KIT', 'keterangan' => null],
            ['name' => 'KM', 'keterangan' => null],
            ['name' => 'L', 'keterangan' => null],
            ['name' => 'LOT', 'keterangan' => null],
            ['name' => 'M', 'keterangan' => null],
            ['name' => 'M2', 'keterangan' => null],
            ['name' => 'M3', 'keterangan' => null],
            ['name' => 'MG', 'keterangan' => null],
            ['name' => 'MIN', 'keterangan' => null],
            ['name' => 'ML', 'keterangan' => null],
            ['name' => 'MON', 'keterangan' => null],
            ['name' => 'OZ', 'keterangan' => null],
            ['name' => 'PAD', 'keterangan' => null],
            ['name' => 'PAL', 'keterangan' => null],
            ['name' => 'PL', 'keterangan' => null],
            ['name' => 'PR', 'keterangan' => null],
            ['name' => 'RM', 'keterangan' => null],
            ['name' => 'SHT', 'keterangan' => null],
            ['name' => 'TU', 'keterangan' => null],
            ['name' => 'W', 'keterangan' => null],
            ['name' => 'WK', 'keterangan' => null],
            ['name' => 'YD', 'keterangan' => null],
            ['name' => 'YR', 'keterangan' => null],
            ['name' => 'BOTTLE', 'keterangan' => null],
            ['name' => 'EACH', 'keterangan' => null],
            ['name' => 'FOOT', 'keterangan' => null],
            ['name' => 'GRAM', 'keterangan' => null],
            ['name' => 'GALLON', 'keterangan' => null],
            ['name' => 'HECTARE', 'keterangan' => null],
            ['name' => 'INCH', 'keterangan' => null],
            ['name' => 'LITRE', 'keterangan' => null],
            ['name' => 'SQUARE METER', 'keterangan' => null],
            ['name' => 'CUBIC METER', 'keterangan' => null],
            ['name' => 'MILIGRAM', 'keterangan' => null],
            ['name' => 'MINUTE', 'keterangan' => null],
            ['name' => 'MILILITER', 'keterangan' => null],
            ['name' => 'MONTH', 'keterangan' => null],
            ['name' => 'OUNCE', 'keterangan' => null],
            ['name' => 'PACK', 'keterangan' => null],
            ['name' => 'PALLET', 'keterangan' => null],
            ['name' => 'PIECE', 'keterangan' => null],
            ['name' => 'PAIR', 'keterangan' => null],
            ['name' => 'REAM', 'keterangan' => null],
            ['name' => 'ROLL', 'keterangan' => null],
            ['name' => 'SHEET', 'keterangan' => null],
            ['name' => 'TONN', 'keterangan' => null],
            ['name' => 'TUBE', 'keterangan' => null],
            ['name' => 'WATT', 'keterangan' => null],
            ['name' => 'WEEKS', 'keterangan' => null],
            ['name' => 'YARD', 'keterangan' => null],
            ['name' => 'YEAR', 'keterangan' => null],
            ['name' => 'CM3', 'keterangan' => null],
        ];
        Uom::query()->upsert($uoms, 'id');

        $this->command->info('Start Get data uoms');
        $uoms = Uom::query()->get();
        $this->command->info('End Get data uoms');
        $this->command->info('Start Cleared uoms');
        Elasticsearch::setModel(Uom::class)->cleared();
        $this->command->info('End Cleared uoms');
        $this->command->info('Start Bulk uoms');
        Elasticsearch::setModel(Uom::class)->bulk(UomData::collection($uoms));
        $this->command->info('End Bulk uoms');
    }
}
