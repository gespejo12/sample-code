<?php

namespace App\Repositories;

use DB;
use App\Models\MatchGroup;
use App\Base\BaseRepository;
use Exception;

class MatchGroupRepository extends BaseRepository
{

    /**
     * @inheritDoc
     */
    protected function model()
    {
        return new MatchGroup;
    }

    /**
     * Submit handler service
     *
     * @param MatchGroup $match_group
     */
    public function handlerService(MatchGroup $match_group)
    {
        $minutes = $this->getDispatchDelay($match_group);
        HandleMatchGroupService::dispatch($match_group)->delay(now()->addMinutes($minutes));
    }

    /**
     * Get minutes delay based on retry attemp
     * @param $match_group
     * @return float|int
     */
    private function getDispatchDelay($match_group)
    {
        //get match group settings in settings table
        $maximumRetriesAttempt = app(MatchGroupSettings::class)->handlerServicesMaxAttempts();
        $retryMinutesDelay = app(MatchGroupSettings::class)->handlerServicesRetryDelays();

        //alert slack channel
        if ($match_group->retry_attempt >= $maximumRetriesAttempt) {
            if (app()->environment() !== 'local') {
                Log::channel('slack')->alert("Match Group [{$match_group->id}] has reached maximum retries.");
            }
            throw new Exception('Match Group reached the maximum retry attempts.');
        }

        return $match_group->retry_attempt ? $match_group->retry_attempt * (int) $retryMinutesDelay : 0;
    }
}
