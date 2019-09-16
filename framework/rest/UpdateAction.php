<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\rest;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\ServerErrorHttpException;

/**
 * UpdateAction 实现一个 API 端点，用于更新模型
 *
 * 关于 UpdateAction 的更多使用参考，请查看 [Rest 控制器指南](guide:rest-controllers)。
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class UpdateAction extends Action
{
    /**
     * @var string 在验证和更新模型所指定的场景。
     */
    public $scenario = Model::SCENARIO_DEFAULT;


    /**
     * 更新现有模型
     * @param string $id 模型的主键值
     * @return \yii\db\ActiveRecordInterface 被更新的模型
     * @throws ServerErrorHttpException 如果更新时发生任何错误
     */
    public function run($id)
    {
        /* @var $model ActiveRecord */
        $model = $this->findModel($id);

        if ($this->checkAccess) {
            call_user_func($this->checkAccess, $this->id, $model);
        }

        $model->scenario = $this->scenario;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if ($model->save() === false && !$model->hasErrors()) {
            throw new ServerErrorHttpException('Failed to update the object for unknown reason.');
        }

        return $model;
    }
}
