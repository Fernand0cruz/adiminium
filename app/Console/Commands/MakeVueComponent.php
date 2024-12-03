<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeVueComponent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:vue {name : The name of the Vue component}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Vue component';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = Str::studly($this->argument('name')); // Nome do componente
        $componentDir = resource_path('js/components'); // Diretório onde os componentes são armazenados
        $filePath = $componentDir . "/{$name}.vue";

        // Verifica se o arquivo já existe
        if (file_exists($filePath)) {
            $this->error("The component '{$name}' already exists.");
            return Command::FAILURE;
        }

        // Estrutura básica do componente
        $template = <<<EOT
<script setup>
const props = defineProps({

});
</script>

<template>
    <div>
        <h1>{$name} Component</h1>
    </div>
</template>

<style scoped>
/* Your styles here */
</style>
EOT;

        // Cria o diretório caso não exista
        if (!is_dir($componentDir)) {
            mkdir($componentDir, 0755, true);
        }

        // Cria o arquivo do componente
        file_put_contents($filePath, $template);

        $this->info("Vue component '{$name}' created successfully at {$filePath}.");
        return Command::SUCCESS;
    }
}
