<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Bcscode]].
 *
 * @see Bcscode
 */
class BcscodeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Bcscode[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Bcscode|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
