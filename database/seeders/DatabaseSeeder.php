<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->firstUser()->create();
        User::factory()->secondUser()->create();
        User::factory()->count(25)->create();

        $peripherals = [
            [
                'name' => 'Logitech MX Master 3s',
                'description' => 'Conheça o MX Master 3S – um mouse icônico remasterizado. Sinta cada momento do seu fluxo de trabalho com ainda mais precisão, tato e desempenho, graças aos cliques silenciosos e um sensor de 8000 DPI sobre vidro para 4mm de espessura mínima de vidro.',
                'price' => 650.00,
                'stock_quantity' => 30,
                'photo' => 'https://utfs.io/f/18d74d9f-8767-459f-800f-361b0630a241-nng1v9.webp',
            ],
            [
                'name' => 'Logitech Pro X Superlight',
                'description' => 'Remova todos os obstáculos para vencer com nosso mouse PRO mais leve e rápido de todos os tempos. A nova arma perfeita para os melhores profissionais do mundo, que pesa menos de 63 gramas e proporciona deslizamento quase sem nenhum atrito. O PRO X SUPERLIGHT dá prosseguimento à nossa filosofia de design com ZERØ OPOSIÇÃO — nosso compromisso de remover todos os obstáculos para criar a conexão mais real possível entre o jogador e o jogo.',
                'price' => 750.00,
                'stock_quantity' => 22,
                'photo' => 'https://utfs.io/f/d9c2db1a-ce79-4cec-8b83-6f81feb43221-yqn8tn.webp',
            ],
            [
                'name' => 'Logitech G305 Lightspeed',
                'description' => 'Mouse para jogos sem fio LIGHTSPEED projetado para um desempenho de ponta com as mais recentes inovações tecnológicas. Bateria com duração impressionante de 250 horas. Agora, em uma variedade de cores intensas.',
                'price' => 300.00,
                'stock_quantity' => 40,
                'photo' => 'https://utfs.io/f/6b63e551-7ded-4125-86de-dc033abd8378-n1k78m.webp',
            ],
            [
                'name' => 'Cobra Cherry',
                'description' => 'Uma grande parceria Redragon x Kabum misturando alto desempenho e design exclusivo e inigualável para os gamers do Brasil.',
                'price' => 250.00,
                'stock_quantity' => 15,
                'photo' => 'https://utfs.io/f/86b0c661-1508-447b-bcc3-56771c15925d-ki2thc.webp',
            ],
            [
                'name' => 'Cooler Master MM730',
                'description' => 'O MM730 retém o espírito inovativo da Cooler Master enquanto mantém a estética familiar de um clássico Mouse pra jogos. Cada componente de nível profissional contribui para sua responsividade na velocidade da luz, num piscar de olhos. pés de PTFE genuínos para um deslizar sem igual, sensor óptico com ajuste para até 16.000 DPI, e micro-switches ópticos com qualidade superior de registro e durabilidade.',
                'price' => 350.00,
                'stock_quantity' => 25,
                'photo' => 'https://utfs.io/f/07a0a8fb-ddae-4a42-987f-a1cf3bdf1a90-5fdm5p.png',
            ],
            [
                'name' => 'SuperFrame Flick Pro',
                'description' => 'O Mouse Gamer SuperFrame Flick Pro não economiza quando se trata de precisão. Com o avançado sensor Pixart 3395, sua resolução de até 26.000 DPI proporciona uma precisão sem igual.',
                'price' => 500.00,
                'stock_quantity' => 35,
                'photo' => 'https://utfs.io/f/f39b468b-4482-4113-b755-eb59319c6b01-6zubvz.png',
            ],
            [
                'name' => 'Corsair Elite RGB',
                'description' => 'O mouse CORSAIR M65 RGB ELITE configurável para jogos é o mouse para jogos FPS mais avançado da CORSAIR, com estrutura de alumínio e o mais moderno sensor óptico com 18.000 DPI.',
                'price' => 600.00,
                'stock_quantity' => 18,
                'photo' => 'https://utfs.io/f/f8c443a3-0761-496f-8e1a-c0df815890e1-x1xk42.png',
            ],
            [
                'name' => 'Force One Lynx',
                'description' => 'Nunca fique na mão: o Force One Lynx conta com 2 modos de conexão – com ou sem fio. Jogue sem atraso com o Dongle Sem Fio 2.4 GHz ou o levíssimo Cabo Paracord USB-C.',
                'price' => 460.00,
                'stock_quantity' => 20,
                'photo' => 'https://utfs.io/f/ea5d2dc5-7f00-4112-baac-d56069dbe7bc-xx02t3.png',
            ],
            [
                'name' => 'Marvo M727',
                'description' => 'No universo competitivo dos jogos, cada movimento conta, e a diferença entre a vitória e a derrota muitas vezes está na precisão e no controle que você tem sobre sua jogabilidade. O Mouse Gamer Marvo M727 é um equipamento que vai além, oferecendo precisão excepcional, personalização avançada e um toque de estilo com sua iluminação RGB deslumbrante. Este é o mouse que vai elevar sua experiência de jogo a novos patamares.',
                'price' => 300.00,
                'stock_quantity' => 28,
                'photo' => 'https://utfs.io/f/57a73f67-da5c-40c9-bf20-c703695301e2-4zyakk.png',
            ],
            [
                'name' => 'Logitech Pop Keys',
                'description' =>
                    'Deixe a personalidade estourar na sua mesa e além com POP Keys. Junto com um mouse POP correspondente, deixe seu verdadeiro eu brilhar com uma estética de mesa impressionante e teclas de emoji personalizáveis e divertidas.',
                'price' => 440.00,
                'stock_quantity' => 34,
                'photo' => 'https://utfs.io/f/21a558e0-9983-4a9f-8d59-843be44a42f4-pafepz.webp',
            ],
            [
                'name' => 'Logitech MX Mechanical',
                'description' =>
                    'inta cada momento do seu processo criativo ou cada linha de código com o MX Mechanical irresistivelmente tátil. Apresenta teclas mecânicas de baixo perfil em 3 tipos de switches para feedback satisfatório a cada toque de tecla, iluminação inteligente e Easy-Switch - permitindo que você conecte até 3 dispositivos. Escolha entre o MX Mechanical de tamanho normal com um teclado numérico integrado ou o minimalista MX Mechanical Mini que economiza espaço.',
                'price' => 700.00,
                'stock_quantity' => 27,
                'photo' => 'https://utfs.io/f/a10e0417-9ba0-4628-8efe-40f62a6e7609-vquxtz.webp',
            ],
            [
                'name' => 'Redragon Gamer Ashe',
                'description' =>
                    'O Redragon Ashe Pro chama muita atenção com seu design, sendo uma opção de teclado mecânico com teclas de perfil baixo, visual limpo e conforto aprimorado.',
                'price' => 400.00,
                'stock_quantity' => 18,
                'photo' => 'https://utfs.io/f/ceffcf86-81db-4a97-a45e-75dc64477427-ay233f.png',
            ],
            [
                'name' => 'Ninja Black Noir',
                'description' =>
                    'Aprimore seu desempenho nos jogos com o teclado gamer ninja Black Noir, um teclado feito especialmente para gamers que buscam um teclado silencioso para uso durante a jogatina, misturando conforto e funcionalidades.',
                'price' => 130.00,
                'stock_quantity' => 12,
                'photo' => 'https://utfs.io/f/22e4c854-d678-4aa0-93a5-11aca999e44e-iczfcd.webp',
            ],
            [
                'name' => 'Redragon Lakshmi',
                'description' =>
                    'O Redragon LAKSHMI reúne o que há de melhor em um teclado para seu setup, entrega performance profissional, evita Double Clicks e possui o dobro de vida útil comparado a um teclado mecânico convencional, é o teclado perfeito para quem procura um excelente upgrade para seu setup.',
                'price' => 300.00,
                'stock_quantity' => 20,
                'photo' => 'https://utfs.io/f/32855a52-16eb-4df9-b48b-e50b44f0846a-ihyv3.png',
            ],
            [
                'name' => 'Redragon Kumara Pro',
                'description' =>
                    'Aprimore seu desempenho nos jogos com o Kumara K552-RGB PRO com switch mecânico Magnético Blue de altíssima qualidade garante um tempo de resposta ágil para os mais exigentes gamers.',
                'price' => 550.00,
                'stock_quantity' => 15,
                'photo' => 'https://utfs.io/f/a5f03c79-80da-4532-a02e-80ec125b73b0-14cozz.png',
            ],
            [
                'name' => 'Akko Naruto Shippuden Sasuke',
                'description' =>
                    'O teclado Akko Naruto Shippuden Sasuke 3108V2 é um dos melhores modelos da akko. O switch Akko Pink que acompanha o teclado é excelente e tem um som satisfatório que ganhou o publico mundial. Qualidade, versatilidade e um preço justo para um teclado top de linha!',
                'price' => 780.00,
                'stock_quantity' => 22,
                'photo' => 'https://utfs.io/f/f375172d-157e-4d43-b7ed-cbc61c285ae5-497eca.webp',
            ],
            [
                'name' => 'SuperFrame Ferz',
                'description' =>
                    'O Teclado Gamer SuperFrame Ferz é um teclado mecânico feito para gamers, que apresenta um layout compacto 60% para os usuários que procuram deixar o máximo de espaço possível sobre a mesa.',
                'price' => 330.00,
                'stock_quantity' => 14,
                'photo' => 'https://utfs.io/f/2542a069-7585-4ec9-8c61-728e31617ff6-h7dqwc.png',
            ],
            [
                'name' => 'Logitech Astro A30',
                'description' => 'Com design revolucionário, acústica avançada e conforto ergonômico, o A50 Wireless + Base Station oferece uma experiência de jogo inesquecível.',
                'photo' => 'https://utfs.io/f/ca45cb59-9332-4bb6-8e8d-08bfe81b9f84-1h1tqv.webp',
                'price' => 1500,
                'stock_quantity' => 15, 
            ],
            [
                'name' => 'Logitech Zone Wired Earbuds',
                'description' => 'Ofereça sua melhor imagem e um som excelente nas videochamadas com os Zone Wired Earbuds. Os avançados microfones com redução de ruídos localizados no fone esquerdo capturam claramente cada palavra. Com som integrado com qualidade de estúdio.',
                'photo' => 'https://utfs.io/f/69e51318-6299-4c00-8c9c-073a28068407-a5n61x.webp',
                'price' => 550,
                'stock_quantity' => 20, 
            ],
            [
                'name' => 'Hyperx Cloud Stinger 2',
                'description' => 'HyperX Cloud Stinger 2 - Headset gamer (preto).',
                'photo' => 'https://utfs.io/f/7e51327b-bd7b-440c-a98b-0e9aa23bfafb-qmfx3g.png',
                'price' => 250,
                'stock_quantity' => 25,
            ],
            [
                'name' => 'Dell P2723QE',
                'description' => 'O ComfortView Plus, uma tela integrada com baixa emissão de luz azul e sempre ativa, reduz as emissões potencialmente nocivas de luz azul sem prejudicar as cores. O incrível acabamento preto e a base pequena complementam um sistema de gerenciamento de cabos aprimorado que oculta os cabos no riser do monitor. Experimente o conforto feito para você ao inclinar, girar, rodar e ajustar a altura do monitor (máx. de 150 mm) e encontrar o conforto ideal para visualização.',
                'photo' => 'https://utfs.io/f/e39eb655-1bcb-429a-abc9-c124fa638be8-n4q7lt.png',
                'price' => 2500,
                'stock_quantity' => 19,
            ],
            [
                'name' => 'Dell S3422DWG',
                'description' => 'Monitor curvo WQHD de 34” com VESA DisplayHDR 400 e taxa de atualização de 144 Hz que proporciona uma experiência gamer realmente imersiva.',
                'photo' => 'https://utfs.io/f/14ea65fd-b17e-40fa-b1b5-29bc6d911047-tm0366.png',
                'price' => 3200,
                'stock_quantity' => 21,
            ],
            [
                'name' => 'Dell S3222DGM',
                'description' => 'Monitor curvo QHD de 31,5 com tempo de resposta de 1 ms (MPRT)/2 ms (cinza a cinza), taxa de atualização de 165 Hz e cores 99% sRGB para oferecer imagens nítidas aos games e tornar a jogabilidade imersiva.',
                'photo' => 'https://utfs.io/f/13103244-dbda-4667-a885-11d368aa528c-x091g8.png',
                'price' => 3500,
                'stock_quantity' => 17,
            ],
        ];

        foreach ($peripherals as $peripheral) {
            Product::create($peripheral);
        }
    }
}
