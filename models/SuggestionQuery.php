<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Suggestion]].
 *
 * @see Suggestion
 */
class SuggestionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Suggestion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Suggestion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
