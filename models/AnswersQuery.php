<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Answers]].
 *
 * @see Answers
 */
class AnswersQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Answers[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Answers|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
