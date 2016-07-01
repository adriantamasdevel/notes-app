<?php

class ApiTest extends TestCase
{

    /**
     * @return void
     */
    public function testSuccessfullyCreateNewNote()
    {

        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $totalNotes = $content->meta->pagination->total;


        $response = $this->call('POST', 'api/notes/', [
            'content'              => 'This is a test note!'
        ])->header('Accept', 'application/json');
        $this->assertEquals('201', $response->status());


        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $totalNotesAfter = $content->meta->pagination->total;

        $this->assertLessThan($totalNotesAfter, $totalNotes);
    }

    /**
     * @return void
     */
    public function testSuccessfullyShowNotes()
    {
        $response = $this->call('GET', 'api/notes/');
        $this->assertContains('data', $response->content());
    }

    /**
     * @return void
     */
    public function testSuccessfullyGetNote()
    {

        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $noteId = $content->data[0]->id;
        $noteContent = $content->data[0]->content;

        $response = $this->call('GET', 'api/notes/'.$noteId)->header('Accept', 'application/json');
        $this->assertEquals('200', $response->status());

        $content = json_decode($response->content());
        $itemNoteId = $content->data->id;
        $itemNoteContent = $content->data->content;

        $this->assertEquals($noteId, $itemNoteId);
        $this->assertEquals($noteContent, $itemNoteContent);

    }

    /**
     * @return void
     */
    public function testSuccessfullyUpdateNote()
    {

        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $noteId = $content->data[0]->id;

        $data = array(
            'id' => $noteId,
            'content' => 'Test content'
        );

        $response = $this->call('PUT', 'api/notes/', $data)->header('Accept', 'application/json');
        $this->assertEquals('200', $response->status());
    }

    /**
     * @return void
     */
    public function testSuccessfullyDeleteNote()
    {

        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $noteId = $content->data[0]->id;

        $response = $this->call('DELETE', 'api/notes/'.$noteId)->header('Accept', 'application/json');
        $this->assertEquals('200', $response->status());

        $response = $this->call('GET', 'api/notes/');
        $content = json_decode($response->content());
        $newNoteId = $content->data[0]->id;

        $this->assertNotEquals($noteId, $newNoteId);

    }
}
