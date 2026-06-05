<?php

namespace Tests\Unit;

use App\Services\VisitSessionIdResolver;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class VisitSessionIdResolverTest extends TestCase
{
    private VisitSessionIdResolver $resolver;

    protected function setUp(): void
    {
        parent::setUp();

        $this->resolver = new VisitSessionIdResolver;
    }

    public function test_resolves_plain_uuid(): void
    {
        $uuid = '58731270-016e-4c35-81d9-07e20691cab0';

        $this->assertSame($uuid, $this->resolver->resolve($uuid));
    }

    public function test_resolves_session_payload_with_uuid_suffix(): void
    {
        $payload = 'b7a14d724f04543c75528824b08fdcaa73f129de|58731270-016e-4c35-81d9-07e20691cab0';

        $this->assertSame(
            '58731270-016e-4c35-81d9-07e20691cab0',
            $this->resolver->resolve($payload)
        );
    }

    public function test_resolves_encrypted_laravel_session_cookie_payload(): void
    {
        $encrypted = Crypt::encryptString(
            'b7a14d724f04543c75528824b08fdcaa73f129de|58731270-016e-4c35-81d9-07e20691cab0'
        );

        $this->assertSame(
            '58731270-016e-4c35-81d9-07e20691cab0',
            $this->resolver->resolve($encrypted)
        );
    }

    public function test_rejects_invalid_value(): void
    {
        $this->assertNull($this->resolver->resolve('not-a-valid-session-id'));
    }
}
