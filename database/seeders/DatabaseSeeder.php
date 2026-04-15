<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Curso;
use App\Models\Denuncia;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Criar usuários de teste
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'phone' => '+55 11 99999-9999',
                'country' => 'Brasil',
            ]
        );

        User::updateOrCreate(
            ['email' => 'moderador@example.com'],
            [
                'name' => 'Moderador',
                'password' => Hash::make('password123'),
                'role' => 'moderator',
                'is_active' => true,
                'phone' => '+55 11 99999-8888',
                'country' => 'Brasil',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Usuário Teste',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
                'phone' => '+55 11 99999-7777',
                'country' => 'Brasil',
            ]
        );

        // Criar cursos
        $cursos = [
            [
                'titulo' => 'Introdução a Segurança Digital',
                'descricao' => 'Aprenda os fundamentos da segurança digital e proteja-se contra ameaças comuns',
                'conteudo' => 'Conteúdo do curso sobre segurança básica...',
                'nivel' => 'iniciante',
                'duracao_minutos' => 120,
                'categoria' => 'Segurança Básica',
                'is_published' => true,
                'ordem' => 1,
            ],
            [
                'titulo' => 'Phishing e Engenharia Social',
                'descricao' => 'Entenda como funcionam ataques de phishing e como se proteger',
                'conteudo' => 'Conteúdo sobre phishing e técnicas de proteção...',
                'nivel' => 'intermediario',
                'duracao_minutos' => 180,
                'categoria' => 'Ameaças Online',
                'is_published' => true,
                'ordem' => 2,
            ],
            [
                'titulo' => 'Criptografia e Privacidade',
                'descricao' => 'Aprenda sobre criptografia e como manter sua privacidade online',
                'conteudo' => 'Conteúdo avançado sobre criptografia...',
                'nivel' => 'avancado',
                'duracao_minutos' => 240,
                'categoria' => 'Privacidade',
                'is_published' => true,
                'ordem' => 3,
            ],
        ];

        foreach($cursos as $curso) {
            Curso::create($curso);
        }

        // Criar denúncias de exemplo
        $user = User::where('role', 'user')->first();
        if($user) {
            Denuncia::create([
                'user_id' => $user->id,
                'titulo' => 'Phishing de conta bancária detectado',
                'descricao' => 'Recebi um email aparentemente do banco solicitando meus dados de login. O link redirecionava para um site falso.',
                'tipo' => 'phishing',
                'url_suspeita' => 'https://banco-falso.example.com',
                'status' => 'pendente',
                'prioridade' => 'alta',
                'localizacao' => 'São Paulo, Brasil',
                'data_incidente' => now()->toDateString(),
            ]);

            Denuncia::create([
                'user_id' => $user->id,
                'titulo' => 'Site com malware suspeito',
                'descricao' => 'Ao acessar o site, um aplicativo foi instalado automaticamente.',
                'tipo' => 'malware',
                'status' => 'pendente',
                'prioridade' => 'alta',
                'localizacao' => 'Rio de Janeiro, Brasil',
                'data_incidente' => now()->toDateString(),
            ]);
        }
    }
}
