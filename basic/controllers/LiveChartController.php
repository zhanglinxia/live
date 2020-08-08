<?php

namespace app\controllers;

use app\models\LiveOuts;
use Yii;
use app\models\LiveChart;
use app\searches\LiveChartSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * LiveChartController implements the CRUD actions for LiveChart model.
 */
class LiveChartController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all LiveChart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LiveChartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LiveChart model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new LiveChart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LiveChart();
        if (strtolower(\Yii::$app->request->method) == 'post') {
            $model->game_id = 1;
            $model->user_id = 1;
            $model->content = $_POST['content'];
            $data = [
                'message'=>$model->content
            ];
            if($model->save()){
                    $http_server = $_POST['http_server'];
                    $chart_server = $http_server->ports[1];
                    error_log(print_r($chart_server,true));
                    foreach ($chart_server->connections as $fd) {
                        if ($http_server->isEstablished($fd)) {
                            $ret = $http_server->push($fd, json_encode($data));
                            error_log(print_r($ret, true));
                        }
                    }
                return $this->render('view', ['model' => $model]);
            }
        }
        return $this->render('create',['model' => $model]);
    }

    /**
     * Updates an existing LiveChart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LiveChart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the LiveChart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LiveChart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LiveChart::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
