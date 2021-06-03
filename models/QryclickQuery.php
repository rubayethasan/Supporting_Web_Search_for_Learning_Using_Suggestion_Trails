<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Qryclick]].
 *
 * @see Qryclick
 */
class QryclickQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Qryclick[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Qryclick|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
