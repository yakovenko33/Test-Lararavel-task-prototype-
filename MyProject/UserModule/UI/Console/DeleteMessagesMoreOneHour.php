<?php


namespace MyProject\UserModule\UI\Console;

use Carbon\Carbon;
use Illuminate\Console\Command;
use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;

class DeleteMessagesMoreOneHour extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:messages_more_hour';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete messages more one hour';

    /**
     * @var MessagesRepositoryInterface
     */
    private $messagesRepository;

    /**
     * DeleteMessagesMoreOneHour constructor.
     * @param MessagesRepositoryInterface $messagesRepository
     */
    public function __construct(MessagesRepositoryInterface $messagesRepository)
    {
        $this->messagesRepository = $messagesRepository;
        parent::__construct();
    }

    /*
     *
     */
    public function handle(): void
    {
        $start = new Carbon();

        $this->info('Start delete messages from messages table');
        $this->messagesRepository->deleteMoreOneHour();
        $this->info("End delete messages from messages. Execute time: {$start->diffInSeconds()} sec");
    }
}
