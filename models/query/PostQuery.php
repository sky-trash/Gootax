<?php

namespace app\models\query;

use yii\db\ActiveQuery;

class PostQuery extends ActiveQuery
{
  public function published()
  {
    return $this->andWhere(['status' => \app\models\Post::STATUS_PUBLISHED]);
  }

  public function draft()
  {
    return $this->andWhere(['status' => \app\models\Post::STATUS_DRAFT]);
  }

  public function recent($limit = 10)
  {
    return $this->published()->orderBy(['created_at' => SORT_DESC])->limit($limit);
  }
}
