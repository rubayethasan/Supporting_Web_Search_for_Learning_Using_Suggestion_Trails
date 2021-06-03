<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Modaltrace]].
 *
 * @see Modaltrace
 */
class ModaltraceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Modaltrace[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Modaltrace|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
