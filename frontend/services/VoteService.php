<?php
declare(strict_types=1);

namespace frontend\services;

use common\interfaces\ExecutableInterface;
use common\models\Girl;
use common\models\Vote;

/**
 * Class VoteService
 * @package frontend\services
 */
class VoteService implements ExecutableInterface
{
    private const COEFFICIENT_JUNIOR = 25;
    private const COEFFICIENT_MIDDLE = 15;
    private const COEFFICIENT_SENIOR = 10;

    private const JUNIOR_LIMIT = 15;
    private const MIDDLE_LIMIT = 2400;

    /**
     * @var Vote $vote
     */
    private Vote $vote;

    /**
     * @var int $winnerId
     */
    private int $winnerId;

    /**
     * @param Vote $vote
     * @param int $winnerId
     */
    public function __construct(Vote $vote, int $winnerId)
    {
        $this->vote = $vote;
        $this->winnerId = $winnerId;
    }

    /**
     * @return bool
     */
    public function execute(): bool
    {
        if ($this->vote->girl_id_winner) {
            return false;
        }

        if (!in_array($this->winnerId, [$this->vote->girl_id_one, $this->vote->girl_id_two])) {
            return false;
        }

        $this->updateVote();
        $this->updateGirls();

        return true;
    }

    /**
     * @return void
     */
    private function updateVote(): void
    {
        $this->vote->girl_id_winner = $this->winnerId;
        $this->vote->save();
    }

    /**
     * @return void
     */
    private function updateGirls(): void
    {
        $girlOneNewRating = $this->getNewRating($this->vote->girlOne);
        $girlTwoNewRating = $this->getNewRating($this->vote->girlTwo);

        $this->vote->girlOne->rating = $girlOneNewRating;
        $this->vote->girlOne->votes++;
        $this->vote->girlOne->save();

        $this->vote->girlTwo->rating = $girlTwoNewRating;
        $this->vote->girlTwo->votes++;
        $this->vote->girlTwo->save();
    }

    /**
     * @param Girl $girl
     * @return float
     */
    private function getNewRating(Girl $girl): float
    {
        return round(
            $girl->rating
            + $this->getCoefficient($girl)
            * ($this->getScoredPoints($girl) - $this->getExpectedPoints($girl))
        );
    }

    /**
     * @param Girl $girl
     * @return int
     */
    private function getCoefficient(Girl $girl): int
    {
        if ($girl->votes <= self::JUNIOR_LIMIT) {
            return self::COEFFICIENT_JUNIOR;
        }

        if ($girl->rating <= self::MIDDLE_LIMIT) {
            return self::COEFFICIENT_MIDDLE;
        }

        return self::COEFFICIENT_SENIOR;
    }

    /**
     * @param Girl $girl
     * @return int
     */
    private function getScoredPoints(Girl $girl): int
    {
        if ($this->vote->girl_id_winner === $girl->id) {
            return 1;
        }
        return 0;
    }

    /**
     * @param Girl $girl
     * @return float
     */
    private function getExpectedPoints(Girl $girl): float
    {
        return 1 / (1 + 10 ** (($girl->rating - $this->getOpponentRating($girl)) / 400));
    }

    /**
     * @param Girl $girl
     * @return int
     */
    private function getOpponentRating(Girl $girl): int
    {
        $opponent = $this->vote->girlOne;
        if ($this->vote->girl_id_one === $girl->id) {
            $opponent = $this->vote->girlTwo;
        }

        return $opponent->rating;
    }
}