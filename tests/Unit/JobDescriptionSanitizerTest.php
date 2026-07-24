<?php

namespace Tests\Unit;

use App\Support\JobDescriptionSanitizer;
use PHPUnit\Framework\TestCase;

class JobDescriptionSanitizerTest extends TestCase
{
    public function test_it_removes_unsafe_html(): void
    {
        $dirty = '<p><strong>Role</strong></p><script>alert("xss")</script>';

        $this->assertSame(
            '<p><strong>Role</strong></p>',
            JobDescriptionSanitizer::clean($dirty),
        );
    }

    public function test_it_keeps_basic_formatting_and_colors(): void
    {
        $dirty = '<p><em>Hello</em> <span style="color: rgb(255, 0, 0);">world</span></p>';

        $clean = JobDescriptionSanitizer::clean($dirty);

        $this->assertStringContainsString('<em>Hello</em>', $clean);
        $this->assertStringContainsString('style="color: rgb(255, 0, 0);"', $clean);
    }

    public function test_it_detects_empty_descriptions(): void
    {
        $this->assertTrue(JobDescriptionSanitizer::isEmpty('<p><br></p>'));
        $this->assertFalse(JobDescriptionSanitizer::isEmpty('<p>Hello</p>'));
    }
}
