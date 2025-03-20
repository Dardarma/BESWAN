<?php
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\E_book;

class EBookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_e_book()
    {
        $file = UploadedFile::fake()->create('ebook.pdf', 1000, 'application/pdf');
        $tumbnail = UploadedFile::fake()->image('tumbnail.jpg', 100, 100);

        $response = $this->withoutMiddleware()->post('/module/create', [
            'judul' => 'E-book Laravel',
            'deskripsi' => 'E-book Laravel',
            'url_file' => $file,
            'author' => 'Laravel',
            'tumbnail' => $tumbnail
        ]);

        $response->assertStatus(302);
        $response->assertSessionHas('success', 'Data berhasil ditambahkan');

        $this->assertDatabaseHas('e_books', [
            'judul' => 'E-book Laravel',
            'deskripsi' => 'E-book Laravel',
            'author' => 'Laravel'
        ]);
    }

    public function test_validation_fails_without_required_fields()
    {
        $response = $this->withoutMiddleware()->post('/module/create', []);

        $response->assertSessionHasErrors([
            'judul',
            'deskripsi',
            'url_file',
            'author',
            'tumbnail',
        ]);
    }


}
