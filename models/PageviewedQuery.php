<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Pageviewed]].
 *
 * @see Pageviewed
 */
class PageviewedQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Pageviewed[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Pageviewed|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
