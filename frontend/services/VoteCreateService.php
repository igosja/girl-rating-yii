<?php
declare(strict_types=1);

namespace frontend\services;

use common\interfaces\ExecutableInterface;
use common\models\Girl;
use common\models\Vote;

/**
 * Class VoteCreateService
 * @package frontend\services
 */
class VoteCreateService implements ExecutableInterface
{
    /**
     * @var Girl[] $girls
     */
    private array $girls = [];

    /**
     * @var Vote|null $vote
     */
    private ?Vote $vote = null;

    /**
     * @return bool
     */
    public function execute(): bool
    {
        $this->loadGirls();
        $this->createVote();
        return true;
    }

    /**
     * @return int
     */
    public function getVoteId(): int
    {
        return $this->vote->id;
    }

    /**
     * @return void
     */
    private function loadGirls(): void
    {
        $this->girls = Girl::find()
            ->orderBy('RAND()')
            ->limit(2)
            ->all();
    }

    /**
     * @return void
     */
    private function createVote(): void
    {
        $this->vote = new Vote();
        $this->vote->girl_id_one = $this->girls[0]->id;
        $this->vote->girl_id_two = $this->girls[1]->id;
        $this->vote->save();
    }
}