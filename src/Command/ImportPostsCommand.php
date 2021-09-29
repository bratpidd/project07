<?php

namespace App\Command;

use App\Services\PostServiceInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class ImportPostsCommand extends Command
{
    /**
     * @var PostServiceInterface
     */
    private $postService;

    public function __construct(PostServiceInterface $postService) {
        $this->postService = $postService;

        parent::__construct();
    }
    protected static $defaultName = 'app:import-posts';

    protected function configure()
    {
        $this->setName('import-posts')
            ->setDescription('Imports POSTS!')
            ->setHelp('Demonstration of custom commands created by Symfony Console component.')
            ->addArgument('filename', InputArgument::REQUIRED, 'Pass the JSON filename.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonFileContent = file_get_contents($input->getArgument('filename'));
        $fileContent = json_decode($jsonFileContent);
        foreach ($fileContent as $post) {
            // dump($post->tags);
            $this->postService->createPost($post->message, $post->tags);
        }
// dd($fileContent);
        $output->writeln($jsonFileContent);
        return Command::SUCCESS;
    }
}