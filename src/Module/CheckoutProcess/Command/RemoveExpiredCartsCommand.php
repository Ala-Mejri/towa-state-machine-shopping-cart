<?php

namespace App\Module\CheckoutProcess\Command;

use App\Module\CheckoutProcess\Business\RemoveExpiredCarts;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:remove-expired-carts',
)]
class RemoveExpiredCartsCommand extends Command
{
    const DEFAULT_MAX_INACTIVITY_DAYS = 7;

    public function __construct(private readonly RemoveExpiredCarts $removeExpiredCarts)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Removes expired carts that have been inactive for a defined period')
            ->addArgument(
                'days',
                InputArgument::OPTIONAL,
                'The number of days a cart can remain inactive',
                self::DEFAULT_MAX_INACTIVITY_DAYS
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $days = $input->getArgument('days');

        if ($days <= 0) {
            $io->error('The number of days should be greater than 0.');

            return Command::FAILURE;
        }

        $expiredCartsCount = $this->removeExpiredCarts->deleteInactiveOrders($days);
        $this->displayConsoleResultMessage($io, $expiredCartsCount);

        return Command::SUCCESS;
    }

    private function displayConsoleResultMessage(SymfonyStyle $io, int $expiredCartsCount): void
    {
        if ($expiredCartsCount > 0) {
            $io->success("$expiredCartsCount cart(s) have been removed.");

            return;
        }

        $io->info('No expired carts found.');
    }
}
