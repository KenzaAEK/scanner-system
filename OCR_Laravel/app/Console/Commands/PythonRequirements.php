<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class PythonRequirements extends Command
{
    protected $signature = 'python:requirements';
    protected $description = 'Install Python dependencies from scripts/requirements.txt';

    public function handle()
    {
        $requirementsPath = base_path('scripts/requirements.txt');

        if (!file_exists($requirementsPath)) {
            $this->warn('Le fichier requirements.txt est introuvable.');
            return Command::FAILURE;
        }

        $this->info("Installation des dépendances Python...");

        $process = new Process(['pip', 'install', '-r', $requirementsPath]);
        $process->setTimeout(300);

        $process->run(function ($type, $buffer) {
            echo $buffer;
        });

        if ($process->isSuccessful()) {
            $this->info("Dépendances Python installées avec succès.");
            return Command::SUCCESS;
        } else {
            $this->error("Échec de l'installation:\n" . $process->getErrorOutput());
            return Command::FAILURE;
        }
    }
}
