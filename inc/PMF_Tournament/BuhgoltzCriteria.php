<?php

class PMF_Tournament_BuhgoltzCriteria extends PMF_Tournament_AbstractCriteria
{
    protected function compare($participant_a, $participant_b)
    {
        return $participant_b->factor - $participant_a->factor;
    }
}
