<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Completion]].
 *
 * @see Completion
 */
class CompletionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Completion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Completion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
