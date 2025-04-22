<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $companies = Company::factory()->count(75)->create();
        $firstCompany = $companies->first();

        $companies->each(function ($company, $index) use ($firstCompany) {
            $userData = [
                'company_id' => $company->id,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'password' => Hash::make('password'),
                'role' => 'client',
            ];

            if ($index === 0) {
                $userData['name'] = 'User Admin';
                $userData['email'] = 'admin@gmail.com';
                $userData['role'] = 'admin';
            } elseif ($index === 1) {
                $userData['name'] = 'User Simples';
                $userData['email'] = 'user@gmail.com';
            }

            User::factory()->create($userData);
        });

        $peripherals = [
            [
                'name' => 'Logitech MX Master 3s',
                'description' => 'Conheça o MX Master 3S – um mouse icônico remasterizado. Sinta cada momento do seu fluxo de trabalho com ainda mais precisão, tato e desempenho, graças aos cliques silenciosos e um sensor de 8000 DPI sobre vidro para 4mm de espessura mínima de vidro.',
                'price' => 650.00,
                'discount'=> 5,
                'quantity' => 30,
                'image' => 'https://utfs.io/f/18d74d9f-8767-459f-800f-361b0630a241-nng1v9.webp',
            ],
            [
                'name' => 'Logitech Pro X Superlight',
                'description' => 'Remova todos os obstáculos para vencer com nosso mouse PRO mais leve e rápido de todos os tempos. A nova arma perfeita para os melhores profissionais do mundo, que pesa menos de 63 gramas e proporciona deslizamento quase sem nenhum atrito. O PRO X SUPERLIGHT dá prosseguimento à nossa filosofia de design com ZERØ OPOSIÇÃO — nosso compromisso de remover todos os obstáculos para criar a conexão mais real possível entre o jogador e o jogo.',
                'price' => 750.00,
                'discount'=> 10,
                'quantity' => 22,
                'image' => 'https://utfs.io/f/d9c2db1a-ce79-4cec-8b83-6f81feb43221-yqn8tn.webp',
            ],
            [
                'name' => 'Logitech G305 Lightspeed',
                'description' => 'Mouse para jogos sem fio LIGHTSPEED projetado para um desempenho de ponta com as mais recentes inovações tecnológicas. Bateria com duração impressionante de 250 horas. Agora, em uma variedade de cores intensas.',
                'price' => 300.00,
                'discount'=> 15,
                'quantity' => 40,
                'image' => 'https://utfs.io/f/6b63e551-7ded-4125-86de-dc033abd8378-n1k78m.webp',
            ],
            [
                'name' => 'Cobra Cherry',
                'description' => 'Uma grande parceria Redragon x Kabum misturando alto desempenho e design exclusivo e inigualável para os gamers do Brasil.',
                'price' => 250.00,
                'discount'=> 5,
                'quantity' => 15,
                'image' => 'https://utfs.io/f/86b0c661-1508-447b-bcc3-56771c15925d-ki2thc.webp',
            ],
            [
                'name' => 'Cooler Master MM730',
                'description' => 'O MM730 retém o espírito inovativo da Cooler Master enquanto mantém a estética familiar de um clássico Mouse pra jogos. Cada componente de nível profissional contribui para sua responsividade na velocidade da luz, num piscar de olhos. pés de PTFE genuínos para um deslizar sem igual, sensor óptico com ajuste para até 16.000 DPI, e micro-switches ópticos com qualidade superior de registro e durabilidade.',
                'price' => 350.00,
                'discount'=> 25,
                'quantity' => 25,
                'image' => 'https://utfs.io/f/07a0a8fb-ddae-4a42-987f-a1cf3bdf1a90-5fdm5p.png',
            ],
            [
                'name' => 'SuperFrame Flick Pro',
                'description' => 'O Mouse Gamer SuperFrame Flick Pro não economiza quando se trata de precisão. Com o avançado sensor Pixart 3395, sua resolução de até 26.000 DPI proporciona uma precisão sem igual.',
                'price' => 500.00,
                'discount'=> 2,
                'quantity' => 35,
                'image' => 'https://utfs.io/f/f39b468b-4482-4113-b755-eb59319c6b01-6zubvz.png',
            ],
            [
                'name' => 'Corsair Elite RGB',
                'description' => 'O mouse CORSAIR M65 RGB ELITE configurável para jogos é o mouse para jogos FPS mais avançado da CORSAIR, com estrutura de alumínio e o mais moderno sensor óptico com 18.000 DPI.',
                'price' => 600.00,
                'discount'=> 10,
                'quantity' => 18,
                'image' => 'https://utfs.io/f/f8c443a3-0761-496f-8e1a-c0df815890e1-x1xk42.png',
            ],
            [
                'name' => 'Force One Lynx',
                'description' => 'Nunca fique na mão: o Force One Lynx conta com 2 modos de conexão – com ou sem fio. Jogue sem atraso com o Dongle Sem Fio 2.4 GHz ou o levíssimo Cabo Paracord USB-C.',
                'price' => 460.00,
                'discount'=> 0,
                'quantity' => 20,
                'image' => 'https://utfs.io/f/ea5d2dc5-7f00-4112-baac-d56069dbe7bc-xx02t3.png',
            ],
            [
                'name' => 'Marvo M727',
                'description' => 'No universo competitivo dos jogos, cada movimento conta, e a diferença entre a vitória e a derrota muitas vezes está na precisão e no controle que você tem sobre sua jogabilidade. O Mouse Gamer Marvo M727 é um equipamento que vai além, oferecendo precisão excepcional, personalização avançada e um toque de estilo com sua iluminação RGB deslumbrante. Este é o mouse que vai elevar sua experiência de jogo a novos patamares.',
                'price' => 300.00,
                'discount'=> 0,
                'quantity' => 28,
                'image' => 'https://utfs.io/f/57a73f67-da5c-40c9-bf20-c703695301e2-4zyakk.png',
            ],
            [
                'name' => 'Logitech Pop Keys',
                'description' =>
                    'Deixe a personalidade estourar na sua mesa e além com POP Keys. Junto com um mouse POP correspondente, deixe seu verdadeiro eu brilhar com uma estética de mesa impressionante e teclas de emoji personalizáveis e divertidas.',
                'price' => 440.00,
                'discount'=> 15,
                'quantity' => 34,
                'image' => 'https://utfs.io/f/21a558e0-9983-4a9f-8d59-843be44a42f4-pafepz.webp',
            ],
            [
                'name' => 'Logitech MX Mechanical',
                'description' =>
                    'inta cada momento do seu processo criativo ou cada linha de código com o MX Mechanical irresistivelmente tátil. Apresenta teclas mecânicas de baixo perfil em 3 tipos de switches para feedback satisfatório a cada toque de tecla, iluminação inteligente e Easy-Switch - permitindo que você conecte até 3 dispositivos. Escolha entre o MX Mechanical de tamanho normal com um teclado numérico integrado ou o minimalista MX Mechanical Mini que economiza espaço.',
                'price' => 700.00,
                'discount'=> 15,
                'quantity' => 27,
                'image' => 'https://utfs.io/f/a10e0417-9ba0-4628-8efe-40f62a6e7609-vquxtz.webp',
            ],
            [
                'name' => 'Redragon Gamer Ashe',
                'description' =>
                    'O Redragon Ashe Pro chama muita atenção com seu design, sendo uma opção de teclado mecânico com teclas de perfil baixo, visual limpo e conforto aprimorado.',
                'price' => 400.00,
                'discount'=> 0,
                'quantity' => 18,
                'image' => 'https://utfs.io/f/ceffcf86-81db-4a97-a45e-75dc64477427-ay233f.png',
            ],
            [
                'name' => 'Ninja Black Noir',
                'description' =>
                    'Aprimore seu desempenho nos jogos com o teclado gamer ninja Black Noir, um teclado feito especialmente para gamers que buscam um teclado silencioso para uso durante a jogatina, misturando conforto e funcionalidades.',
                'price' => 130.00,
                'discount'=> 5,
                'quantity' => 12,
                'image' => 'https://utfs.io/f/22e4c854-d678-4aa0-93a5-11aca999e44e-iczfcd.webp',
            ],
            [
                'name' => 'Redragon Lakshmi',
                'description' =>
                    'O Redragon LAKSHMI reúne o que há de melhor em um teclado para seu setup, entrega performance profissional, evita Double Clicks e possui o dobro de vida útil comparado a um teclado mecânico convencional, é o teclado perfeito para quem procura um excelente upgrade para seu setup.',
                'price' => 300.00,
                'discount'=> 0,
                'quantity' => 20,
                'image' => 'https://utfs.io/f/32855a52-16eb-4df9-b48b-e50b44f0846a-ihyv3.png',
            ],
            [
                'name' => 'Redragon Kumara Pro',
                'description' =>
                    'Aprimore seu desempenho nos jogos com o Kumara K552-RGB PRO com switch mecânico Magnético Blue de altíssima qualidade garante um tempo de resposta ágil para os mais exigentes gamers.',
                'price' => 550.00,
                'discount'=> 2,
                'quantity' => 15,
                'image' => 'https://utfs.io/f/a5f03c79-80da-4532-a02e-80ec125b73b0-14cozz.png',
            ],
            [
                'name' => 'Akko Naruto Shippuden Sasuke',
                'description' =>
                    'O teclado Akko Naruto Shippuden Sasuke 3108V2 é um dos melhores modelos da akko. O switch Akko Pink que acompanha o teclado é excelente e tem um som satisfatório que ganhou o publico mundial. Qualidade, versatilidade e um preço justo para um teclado top de linha!',
                'price' => 780.00,
                'discount'=> 10,
                'quantity' => 22,
                'image' => 'https://utfs.io/f/f375172d-157e-4d43-b7ed-cbc61c285ae5-497eca.webp',
            ],
            [
                'name' => 'SuperFrame Ferz',
                'description' =>
                    'O Teclado Gamer SuperFrame Ferz é um teclado mecânico feito para gamers, que apresenta um layout compacto 60% para os usuários que procuram deixar o máximo de espaço possível sobre a mesa.',
                'price' => 330.00,
                'discount'=> 15,
                'quantity' => 14,
                'image' => 'https://utfs.io/f/2542a069-7585-4ec9-8c61-728e31617ff6-h7dqwc.png',
            ],
            [
                'name' => 'Logitech Astro A30',
                'description' => 'Com design revolucionário, acústica avançada e conforto ergonômico, o A50 Wireless + Base Station oferece uma experiência de jogo inesquecível.',
                'image' => 'https://utfs.io/f/ca45cb59-9332-4bb6-8e8d-08bfe81b9f84-1h1tqv.webp',
                'price' => 1500,
                'discount'=> 0,
                'quantity' => 15,
            ],
            [
                'name' => 'Logitech Zone Wired Earbuds',
                'description' => 'Ofereça sua melhor imagem e um som excelente nas videochamadas com os Zone Wired Earbuds. Os avançados microfones com redução de ruídos localizados no fone esquerdo capturam claramente cada palavra. Com som integrado com qualidade de estúdio.',
                'image' => 'https://utfs.io/f/69e51318-6299-4c00-8c9c-073a28068407-a5n61x.webp',
                'price' => 550,
                'discount'=> 0,
                'quantity' => 20,
            ],
            [
                'name' => 'Hyperx Cloud Stinger 2',
                'description' => 'HyperX Cloud Stinger 2 - Headset gamer (preto).',
                'image' => 'https://utfs.io/f/7e51327b-bd7b-440c-a98b-0e9aa23bfafb-qmfx3g.png',
                'price' => 250,
                'discount'=> 15,
                'quantity' => 25,
            ],
            [
                'name' => 'Dell P2723QE',
                'description' => 'O ComfortView Plus, uma tela integrada com baixa emissão de luz azul e sempre ativa, reduz as emissões potencialmente nocivas de luz azul sem prejudicar as cores. O incrível acabamento preto e a base pequena complementam um sistema de gerenciamento de cabos aprimorado que oculta os cabos no riser do monitor. Experimente o conforto feito para você ao inclinar, girar, rodar e ajustar a altura do monitor (máx. de 150 mm) e encontrar o conforto ideal para visualização.',
                'image' => 'https://utfs.io/f/e39eb655-1bcb-429a-abc9-c124fa638be8-n4q7lt.png',
                'price' => 2500,
                'discount'=> 0,
                'quantity' => 19,
            ],
            [
                'name' => 'Dell S3422DWG',
                'description' => 'Monitor curvo WQHD de 34” com VESA DisplayHDR 400 e taxa de atualização de 144 Hz que proporciona uma experiência gamer realmente imersiva.',
                'image' => 'https://utfs.io/f/14ea65fd-b17e-40fa-b1b5-29bc6d911047-tm0366.png',
                'price' => 3200,
                'discount'=> 0,
                'quantity' => 21,
            ],
            [
                'name' => 'Dell S3222DGM',
                'description' => 'Monitor curvo QHD de 31,5 com tempo de resposta de 1 ms (MPRT)/2 ms (cinza a cinza), taxa de atualização de 165 Hz e cores 99% sRGB para oferecer imagens nítidas aos games e tornar a jogabilidade imersiva.',
                'image' => 'https://utfs.io/f/13103244-dbda-4667-a885-11d368aa528c-x091g8.png',
                'price' => 3500,
                'discount'=> 0,
                'quantity' => 17,
            ],
            [
                'name' => 'Sony HT-S200F Soundbar',
                'description' => 'Introduzindo a Sony HT-200F Soundbar: sua solução sonora definitiva para transformar sua sala de estar em um verdadeiro cinema em casa. Projetada com a lendária qualidade de áudio da Sony, esta elegante e compacta soundbar oferece uma experiência de áudio imersiva que complementa perfeitamente qualquer ambiente. Com sua potência de saída de 80W, a HT-200F preenche o espaço com um som nítido e envolvente, que torna cada momento de entretenimento uma experiência emocionante. Graças à tecnologia S-Force Front Surround, você desfrutará de um campo sonoro expansivo que simula a experiência de som surround sem a necessidade de alto-falantes adicionais. A conectividade Bluetooth integrada permite que você transmita facilmente música de seus dispositivos compatíveis, enquanto a entrada HDMI ARC simplifica a conexão com sua TV para uma configuração rápida e fácil. Além disso, com o design fino e discreto da HT-200F, ela se integra perfeitamente ao seu espaço de entretenimento, proporcionando um visual elegante e moderno. Desfrute de filmes, música e jogos como nunca antes com a Sony HT-200F Soundbar - onde o áudio excepcional encontra o design sofisticado.',
                'image' => 'https://utfs.io/f/73c66027-3668-4de8-97bd-576b460052fc-k1xrbb.webp',
                'price' => 2500,
                'discount'=> 0,
                'quantity' => 14,
            ],
            [
                'name' => 'Sony XB23 Extra Bass',
                'description' => 'Desfrute de som potente e portabilidade incomparável com a Caixa de Som Sony SRS-XB23. Projetada para os verdadeiros amantes da música que não querem comprometer a qualidade sonora, esta caixa de som combina um design robusto com recursos avançados, garantindo uma experiência auditiva excepcional em qualquer ambiente.',
                'image' => 'https://utfs.io/f/909d2979-a874-4172-922f-2937f8573489-sh030b.png',
                'price' => 3500,
                'discount'=> 5,
                'quantity' => 19,
            ],
            [
                'name' => 'Sony SA-Z9R Speakers',
                'description' => 'Os alto-falantes Sony SA-Z9R foram projetados para elevar a sua experiência auditiva a novos patamares, oferecendo um áudio imersivo e envolvente que coloca você no centro da ação. Como parte do sistema de áudio Sony HT-Z9F, esses alto-falantes traseiros sem fio foram meticulosamente projetados para complementar e aprimorar o desempenho do seu sistema de home theater, proporcionando um som surround realista e emocionante.',
                'image' => 'https://utfs.io/f/f41fd707-a43d-4135-93b0-034039954e95-n3vzru.webp',
                'price' => 4000,
                'discount'=> 10,
                'quantity' => 21,
            ],
            [
                'name' => '8BitDo Fami Edition',
                'description' => 'Domine o jogo com o Teclado Mecânico Gamer 8BitDo Fami Edition. Este teclado sem fio Bluetooth combina o melhor do estilo retrô com a tecnologia moderna, oferecendo uma experiência de digitação excepcional para jogadores exigentes.',
                'image' => 'https://utfs.io/f/d780c0f1-064f-4ef8-b07e-6b0be4813f93-ig2w57.png',
                'price' => 750,
                'discount'=> 8,
                'quantity' => 32,
            ],
            [
                'name' => 'Logitech G740',
                'description' => 'A espessura preferida pelos jogadores profissionais para uma superfície de mesa mais consistente e melhores jogos em LANS e torneios. Obtenha a quantidade certa de resistência aos pés do seu mouse. Perfeito para todos os movimentos de partida, parada e movimentos bruscos e rápidos que vêm com jogos de baixo DPI. A textura de superfície perfeita fornece a imagem ideal para o sensor do seu mouse, para que ele possa traduzir o movimento do mouse para o movimento do cursor.',
                'image' => 'https://utfs.io/f/b1d8cb8b-8559-40cc-aac6-774dc32f24b9-rdtluz.webp',
                'price' => 200,
                'discount'=> 8,
                'quantity' => 12,
            ],
            [
                'name' => 'Force One Skyhawk Dark',
                'description' => 'Mousepad Force One Skyhawk Dark XXL (900x400mm)',
                'image' => 'https://utfs.io/f/6ca36f1a-1062-406f-b5e6-6a695268c37f-11g5.webp',
                'price' => 300,
                'discount'=> 10,
                'quantity' => 16,
            ],
        ];

        foreach ($peripherals as $peripheral) {
            Product::create($peripheral);
        }
    }
}
