<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TagTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_list()
    {
        $route = '/api/tag/list';

        $this->post($route)->assertStatus(302);

        $user = User::getTestUser();
        $this->actingAs($user)->post($route)->assertStatus(200);
    }

    public function test_save()
    {
        $route = '/api/tag/save';
        $user = User::getTestUser();

        // Cadastro
        $this->actingAs($user)->post($route, [
            'cod' => 'a1b2',
            'title' => 'abc'
        ])->assertStatus(200);

        // Cadastro repetido
        $this->actingAs($user)->post($route, [
            'cod' => 'a1b2',
            'title' => 'abc'

        ])->assertStatus(302);

        // Faltando dados
        $this->actingAs($user)->post($route, [
            'cod' => 'a1b2'
        ])->assertStatus(302);

        // Edição
        $this->actingAs($user)->post($route.'/1', [
            'cod' => 'a1b2c3',
            'title' => 'abc',
            'description' => 'AAAAAAAAAAAAAA'
        ])->assertStatus(200);

        // Extrapolando max
        $this->actingAs($user)->post($route.'/1', [
            'cod' => 'a1b2c3',
            'title' => 'abc',
            'description' => 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB'
        ])->assertStatus(302);
    }

    public function test_tag()
    {
        $route = '/api/tag/1';
        $user = User::getTestUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }

    public function test_options()
    {
        $route = '/api/tag/options/1';
        $user = User::getTestUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }

}
