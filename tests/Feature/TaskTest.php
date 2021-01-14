<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_list()
    {
        $route = '/api/task/list';

        // Sem autenticação
        $this->post($route)->assertStatus(302);

        // $user = User::factory()->create();
        $user = User::setFakeUser();

        // Autenticado
        $this->actingAs($user)->post($route)->assertStatus(200);

        // Com filtros
        $this->actingAs($user)->post($route, [
            'cod' => 'a1b2',
            'title' => 'abc',
            'created' => '2021-01-13',
            'status' => 1,
            'tags' => [1, 2, 3]
        ])->assertStatus(200);
    }

    public function test_save()
    {
        $route = '/api/task/save';
        $user = User::setFakeUser();

        // Cadastro
        $this->actingAs($user)->post($route, [
            'cod' => 'a1b2',
            'title' => 'abc',
            'tags' => [1, 2]
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
            'description' => 'AAAAAAAAAAAAAA',
            'tags' => [1, 4, 6]
        ])->assertStatus(200);

        // Extrapolando max
        $this->actingAs($user)->post($route.'/1', [
            'cod' => 'a1b2c3',
            'title' => 'abc',
            'description' => 'BBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBBB',
            'tags' => [1, 4, 6]
        ])->assertStatus(302);
    }

    public function test_task()
    {
        $route = '/api/task/1';
        $user = User::setFakeUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }

    public function test_conclude()
    {
        $route = '/api/task/conclude/1';
        $user = User::setFakeUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }

    public function test_archive()
    {
        $route = '/api/task/archive/1';
        $user = User::setFakeUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }

    public function test_active()
    {
        $route = '/api/task/active/1';
        $user = User::setFakeUser();

        $this->actingAs($user)->get($route)->assertStatus(200);
    }
    
}
