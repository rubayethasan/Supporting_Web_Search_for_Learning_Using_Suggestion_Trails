<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Idleusers]].
 *
 * @see Idleusers
 */
class IdleusersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Idleusers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Idleusers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
