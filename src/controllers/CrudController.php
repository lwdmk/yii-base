<?php
namespace lwdmk\yii2BaseClasses\controllers;

use yii\db\ActiveRecord;

/**
 * Class CrudController
 * @package lwdmk\yii2BaseClasses\controllers
 */
class CrudController extends BaseController
{
    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        /** @var ActiveRecord $searchModel */
        $searchModel = $this->getSearchService()->getSearchModel(\Yii::$app->request->getQueryParams());
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $this->getSearchService()->getSearchResult($searchModel)
        ]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /** @var ActiveRecord $model */
        $model = $this->getCrudService()->createModel();
        if ($model->load(\Yii::$app->request->post()) && $this->getCrudService()->saveModel($model)) {
            return $this->redirect(['update', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing model.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->getCrudService()->getModel($id);
        if ($model->load(\Yii::$app->request->post()) && $this->getCrudService()->saveModel($model)) {
            return $this->refresh();
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->getCrudService()->deleteModel($id);
        return $this->redirect(['index']);
    }
}
