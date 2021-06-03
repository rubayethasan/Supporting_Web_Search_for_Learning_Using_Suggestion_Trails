<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Observationmodaltrace]].
 *
 * @see Observationmodaltrace
 */
class ObservationmodaltraceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Observationmodaltrace[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Observationmodaltrace|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
