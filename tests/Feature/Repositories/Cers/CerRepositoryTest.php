<?php

namespace Tests\Feature\Repositories\Cers;

use App\DataTransferObjects\Cers\CerData;
use App\Models\Cers\Cer;
use App\Repositories\Cers\CerRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CerRepositoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_data()
    {
        $cer = Cer::factory()->make();
        $cerData = CerData::from($cer);

        $cerRepository = new CerRepository();
        $result = $cerRepository->updateOrCreate($cerData);

        $this->assertEquals($cer->no_cer, $result->no_cer);
        $this->assertEquals($cer->nik, $result->nik);
        $this->assertEquals($cer->type_budget, $result->type_budget);
        $this->assertEquals($cer->budget_ref, $result->budget_ref);
        $this->assertEquals($cer->peruntukan, $result->peruntukan);
        $this->assertEquals($cer->tgl_kebutuhan, $result->tgl_kebutuhan);
        $this->assertEquals($cer->justifikasi, $result->justifikasi);
        $this->assertEquals($cer->sumber_pendanaan, $result->sumber_pendanaan);
        $this->assertEquals($cer->cost_analyst, $result->cost_analyst);
        $this->assertEquals($cer->status, $result->status);
    }

    /** @test */
    public function it_can_update_data()
    {
        $cer = Cer::factory()->create();

        $newCer = Cer::factory()->make();
        $cerData = CerData::from(array_merge(['key' => $cer->getKey()], $newCer->toArray()));

        $cerRepository = new CerRepository();
        $result = $cerRepository->updateOrCreate($cerData);

        $this->assertEquals($newCer->no_cer, $result->no_cer);
        $this->assertEquals($newCer->nik, $result->nik);
        $this->assertEquals($newCer->type_budget, $result->type_budget);
        $this->assertEquals($newCer->budget_ref, $result->budget_ref);
        $this->assertEquals($newCer->peruntukan, $result->peruntukan);
        $this->assertEquals($newCer->tgl_kebutuhan, $result->tgl_kebutuhan);
        $this->assertEquals($newCer->justifikasi, $result->justifikasi);
        $this->assertEquals($newCer->sumber_pendanaan, $result->sumber_pendanaan);
        $this->assertEquals($newCer->cost_analyst, $result->cost_analyst);
        $this->assertEquals($newCer->status, $result->status);
    }
}
