<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Completioncode]].
 *
 * @see Completioncode
 */
class CompletioncodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Completioncode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Completioncode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
