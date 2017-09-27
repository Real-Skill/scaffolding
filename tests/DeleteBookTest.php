<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Response;

class DeleteBookTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @before
     */
    public function seedBooks()
    {
        $this->seed(BooksTableSeeder::class);
    }

    /**
     * @test
     */
    public function shouldReturn404StatusCodeIfBookNotExists()
    {
        $this->assertEquals(2, App\Book::count());

        $this->notSeeInDatabase('books', ['id' => 3]);
        $this->json('DELETE', '/api/book/3')
            ->assertResponseStatus(Response::HTTP_NOT_FOUND);
    }
}
