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

        // Despublicar cursos antigos de exemplo
        Curso::whereIn('titulo', [
            'Introdução a Segurança Digital',
            'Phishing e Engenharia Social',
            'Criptografia e Privacidade',
        ])->update(['is_published' => false]);

        // Criar cursos
        $cursos = [
            [
                'titulo' => 'Curso Curto de Segurança Digital no YouTube',
                'descricao' => 'Seleção rápida de vídeos curtos para aprender boas práticas de segurança online, senhas, phishing e proteção de dados.',
                'conteudo' => "Fonte: YouTube\n\nAssista a vídeos curtos sobre:\n- Como criar senhas fortes e usar autenticação em dois fatores.\n- Como identificar mensagens de phishing.\n- Cuidados antes de clicar em links desconhecidos.\n- Proteção de dados pessoais nas redes sociais.\n\nLink sugerido:\nhttps://www.youtube.com/results?search_query=curso+curto+seguran%C3%A7a+digital+phishing+senhas",
                'nivel' => 'iniciante',
                'duracao_minutos' => 45,
                'categoria' => 'YouTube',
                'imagem_capa' => 'https://upload.wikimedia.org/wikipedia/commons/0/09/YouTube_full-color_icon_%282017%29.svg',
                'tags' => ['youtube', 'seguranca-digital', 'phishing', 'senhas'],
                'is_published' => true,
                'ordem' => 1,
            ],
            [
                'titulo' => 'NetAcad: Introduction to Cybersecurity',
                'descricao' => 'Curso introdutório da Cisco Networking Academy para compreender ameaças, ataques, vulnerabilidades e proteção da privacidade online.',
                'conteudo' => "Fonte: Cisco Networking Academy / NetAcad\n\nNeste curso você aprende:\n- O que é cibersegurança e como ela afeta pessoas e organizações.\n- Ameaças, ataques e vulnerabilidades comuns.\n- Como empresas protegem operações contra ataques.\n- Tendências de carreira em cibersegurança.\n\nLink do curso:\nhttps://www.netacad.com/courses/cybersecurity/introduction-cybersecurity",
                'nivel' => 'iniciante',
                'duracao_minutos' => 900,
                'categoria' => 'NetAcad',
                'imagem_capa' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/c/cf/Cisco_Networking_Academy_Logo.png/800px-Cisco_Networking_Academy_Logo.png',
                'tags' => ['netacad', 'cisco', 'cybersecurity', 'iniciante'],
                'is_published' => true,
                'ordem' => 2,
            ],
            [
                'titulo' => 'NetAcad: Cybersecurity Essentials',
                'descricao' => 'Formação da Cisco Networking Academy focada nos princípios essenciais para defender sistemas, redes e dados.',
                'conteudo' => "Fonte: Cisco Networking Academy / NetAcad\n\nNeste curso você aprofunda:\n- Princípios de confidencialidade, integridade e disponibilidade.\n- Segurança de redes, sistemas e endpoints.\n- Conceitos de defesa contra ameaças cibernéticas.\n- Boas práticas para proteção de dados.\n\nLink do curso:\nhttps://www.netacad.com/courses/cybersecurity/cybersecurity-essentials",
                'nivel' => 'intermediario',
                'duracao_minutos' => 1800,
                'categoria' => 'NetAcad',
                'tags' => ['netacad', 'cisco', 'cybersecurity-essentials', 'defesa'],
                'is_published' => true,
                'ordem' => 3,
            ],
            [
                'titulo' => 'NetAcad: Network Security',
                'descricao' => 'Curso avançado da Cisco Networking Academy para desenvolver competências de proteção de redes e prevenção de intrusões.',
                'conteudo' => "Fonte: Cisco Networking Academy / NetAcad\n\nNeste curso você aprende:\n- Como proteger dispositivos, redes e dados.\n- Implementação e suporte de segurança em equipamentos de rede.\n- Uso de pensamento crítico e resolução de problemas com laboratórios práticos.\n- Competências alinhadas a práticas reconhecidas de cibersegurança.\n\nLink do curso:\nhttps://www.netacad.com/courses/cybersecurity/network-security",
                'nivel' => 'avancado',
                'duracao_minutos' => 4200,
                'categoria' => 'NetAcad',
                'tags' => ['netacad', 'cisco', 'network-security', 'redes'],
                'is_published' => true,
                'ordem' => 4,
            ],
        ];

        foreach($cursos as $curso) {
            Curso::updateOrCreate(
                ['titulo' => $curso['titulo']],
                $curso
            );
        }

        // Criar denúncias de exemplo
        $user = User::where('role', 'user')->first();
        if($user) {
            Denuncia::updateOrCreate(
                ['titulo' => 'Phishing de conta bancária detectado'],
                [
                    'user_id' => $user->id,
                    'descricao' => 'Recebi um email aparentemente do banco solicitando meus dados de login. O link redirecionava para um site falso.',
                    'tipo' => 'phishing',
                    'url_suspeita' => 'https://banco-falso.example.com',
                    'status' => 'pendente',
                    'prioridade' => 'alta',
                    'localizacao' => 'São Paulo, Brasil',
                    'data_incidente' => now()->toDateString(),
                ]
            );

            Denuncia::updateOrCreate(
                ['titulo' => 'Site com malware suspeito'],
                [
                    'user_id' => $user->id,
                    'descricao' => 'Ao acessar o site, um aplicativo foi instalado automaticamente.',
                    'tipo' => 'malware',
                    'status' => 'pendente',
                    'prioridade' => 'alta',
                    'localizacao' => 'Rio de Janeiro, Brasil',
                    'data_incidente' => now()->toDateString(),
                ]
            );
        }
    }
}
