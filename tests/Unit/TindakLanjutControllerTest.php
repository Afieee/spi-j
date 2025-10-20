<?php

namespace Tests\Unit;

use App\Enums\Status;
use Tests\TestCase;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Http\Controllers\TindakLanjutController;
use Illuminate\Http\Request;

class TindakLanjutControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Optional: Setup additional configurations or initializations here
    }

    public function testIndexMethod()
    {
        $response = $this->get(route('tindak-lanjut.index'));
        $response->assertStatus(200);
        $response->assertViewIs('Tindak-Lanjut.tindak-lanjut');
    }

    public function testShowMethod()
    {
        $audit = Audit::factory()->create();

        $response = $this->get(route('tindak-lanjut.show', ['auditId' => $audit->id]));

        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'id' => $audit->id,
                // Add other relevant assertions
            ],
            'statusData' => Status::asOptions(),
        ]);
    }

    public function testUpdateMethod()
    {
        Storage::fake('public');

        $audit = Audit::factory()->create();
        $file = UploadedFile::fake()->create('file_dinas.pdf', 100);

        $response = $this->put(route('tindak-lanjut.update', ['auditId' => $audit->id]), [
            'status' => 'Closed',
            'file_dinas' => $file,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['status' => true, 'message' => 'Update status successfully']);

        $this->assertDatabaseHas('audits', [
            'id' => $audit->id,
            'status' => 'Closed',
        ]);

        // Storage::disk('public')->ass('uploads/' . $file->hashName());
    }
}
