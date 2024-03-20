<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use joshtronic\LoremIpsum;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GenerateSummaryPostCommand extends Command
{

    protected static $defaultName = 'app:generate-summary-post';
    protected static $defaultDescription = 'Run app:generate-summary-post';

    private EntityManagerInterface $em;
    private LoremIpsum $loremIpsum;

    public function __construct(EntityManagerInterface $em, LoremIpsum $loremIpsum, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->loremIpsum = $loremIpsum;
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $title = 'Summary ' .  date('Y-m-d');
        $content = $this->loremIpsum->paragraphs(1);

        $post = new Post();
        $post->setTitle($title);
        $post->setContent($content);

        $this->em->persist($post);
        $this->em->flush();

        $output->writeln('A summary post has been generated.');

        return Command::SUCCESS;
    }
}