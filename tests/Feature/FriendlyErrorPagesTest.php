<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Session\TokenMismatchException;
use Tests\TestCase;

class FriendlyErrorPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_not_found_page_is_user_friendly(): void
    {
        $this->get('/this-page-definitely-does-not-exist')
            ->assertNotFound()
            ->assertSee('We could not find that page', false)
            ->assertDontSee('NotFoundHttpException', false);
    }

    public function test_csrf_mismatch_renders_friendly_session_expired_page(): void
    {
        $request = request()->create('/login', 'POST');
        $request->headers->set('Accept', 'text/html');

        $response = $this->app
            ->make(\Illuminate\Contracts\Debug\ExceptionHandler::class)
            ->render($request, new TokenMismatchException);

        $this->assertSame(419, $response->getStatusCode());
        $this->assertStringContainsString('Session expired', $response->getContent());
        $this->assertStringContainsString('inactivity', $response->getContent());
        $this->assertStringNotContainsString('TokenMismatchException', $response->getContent());
    }
}
