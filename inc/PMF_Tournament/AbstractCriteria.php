<?php

abstract class PMF_Tournament_AbstractCriteria
{
    private $wrapped_criteria = null;

    public function __construct(PMF_Tournament_AbstractCriteria $wrapped_criteria = null)
    {
        $this->wrapped_criteria = $wrapped_criteria;
    }

    public function compareParticipants($participant_a, $participant_b)
    {
        $result = $this->compare($participant_a, $participant_b);
        if ($result == 0 && !is_null($this->wrapped_criteria)) {
            return $this->wrapped_criteria->compareParticipants($participant_a, $participant_b);
        }
        return $result;
    }

    protected abstract function compare($participant_a, $participant_b);

    /**
     * @param $criteria_string string like '0,1' where each numbers - criteria type.
     * If criteria goes earlier than it will be processed earlier
     */
    public static function createCompositeCriteria($criteria_string)
    {
        $criteria_array = split(',', $criteria_string);
        $last_criteria = null;
        for ($i = count($criteria_array) - 1; $i >= 0; $i--) {
            $last_criteria = self::createCriteria($criteria_array[$i], $last_criteria);
        }
        return $last_criteria;
    }

    private static function createCriteria($index, PMF_Tournament_AbstractCriteria $wrapped_criteria = null)
    {
        switch ($index) {
            case 0:
                return new PMF_Tournament_BergerCriteria($wrapped_criteria);
            case 1:
                return new PMF_Tournament_BuhgoltzCriteria($wrapped_criteria);
        }
    }

}
