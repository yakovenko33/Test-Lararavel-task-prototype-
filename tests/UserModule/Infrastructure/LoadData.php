<?php


namespace Tests\UserModule\Infrastructure;


use MyProject\UserModule\Infrastructure\Interfaces\MessagesRepositoryInterface;

class LoadData
{
    /**
     * @var MessagesRepositoryInterface
     */
    private $messagesRepository;

    /**
     * LoadData constructor.
     * @param MessagesRepositoryInterface $messagesRepository
     */
    public function __construct(MessagesRepositoryInterface $messagesRepository)
    {
        $this->messagesRepository = $messagesRepository;
    }

    /**
     * @param int $count
     */
    public function addData(int $count = 10): void
    {
        for($i = 1; $i <= $count; $i++) {
            $this->messagesRepository->insert([
                'user_id' => $i,
                'text' => "Message " . $i
            ]);
        }
    }
}
